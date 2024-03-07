<?php

namespace App\Http\Livewire;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Box;
use App\Models\Carrier;
use App\Models\Insurance;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\Settings;
use App\Models\Shipping;
use App\Models\UserData;
use App\Models\Warehouse;
use App\Models\WarehousePriceRatio;
use App\Models\WarehouseRateRatio;
use App\Models\WarehouseRatio;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Repository\ImpInterface;
use PHPUnit\Framework\Constraint\Count;

class PlaceOrderWizard extends Component
{
    use WithFileUploads;

    public $user = null;
    public $order_id = null;
    public $order_status = "Pending";
    public $currentStep = 0;
    public $order_id_generated = null;

    public $country_id = null;
    public $countries = [];

    public $current_product = null;
    public $outgoing_product = null;
    public $editing_product = null;
    public $incoming_total_items = 0;
    public $products = [];
    public $products_exported = null;
    public $products_list_old = [];
    public $products_not_packed = [];
    public $product_count = 0;
    public $bins = [];

    public $combine_products = true;
    public $shippings = [];
    public $carriers = [];
    public $carrier_selected = null;

    public $services = [];
    public $servicesDB = [];
    public $user_services = null;
    public $discount = 0;

    public $fba_labels = [];
    public $fba_labels_arr = [];
    public $fnsku_labels = [];
    public $fnsku_labels_arr = [];
    public $product_fba_labels_arr = [];
    public $sku_label_count = 0;

    public $warehouses = [];
    public $shipping_address = null;
    public $fba_warehouse_select = true;
    public $add_shipping_details_later = false;

    public $order_total = 0;

    public $totalPrice = 0;
    public $totalWeight = 0;
    public $totalDeci = 0;
    public $totalQty = 0;

    public $show_tracking_form = false;
    public $is_tracking_set = false;
    public $tracking_info = null;

    public $warehouse_address = null;
    public $is_express = true;


    protected $listeners = ['searchProduct', 'searchOutgoingProduct', 'addProduct', 'removeProduct', 'incrementStepCounter', 'decrementStepCounter', 'resetProductForm', 'setTrackingInfo'];
    /**
     * Initialize Livewire Order from
     */
    public function mount($products_exported)
    {
        if ($products_exported) {
            $this->products_exported = $products_exported;
            $this->is_express = false;
        }

        $this->user = Auth::user();
        $this->order_id = time() . random_int(100, 999);
        $this->countries = Country::all();
        $this->servicesDB = Service::all();
        $user_data = UserData::where('user_id', $this->user->id)->first();
        $this->user_services = $user_data->services ? json_decode($user_data->services, true) : [];
        $this->discount = $user_data->discount ? $user_data->discount : 0;

        $this->shippings = Shipping::all();

        $warehouse_address = Settings::select('address')->where('id', 1)->first();
        if ($warehouse_address) {
            $this->warehouse_address = json_decode($warehouse_address['address'], true);
        } else {
            $this->warehouse_address['name'] = '';
            $this->warehouse_address['street'] = '';
            $this->warehouse_address['city'] = '';
            $this->warehouse_address['state'] = '';
            $this->warehouse_address['zip'] = '';
        }
    }

    public function render()
    {
        return view('user.order.wizard-form');
    }

    public function toggleTrackingForm($mode)
    {
        $this->show_tracking_form = $mode;
    }

    public function setTrackingInfo($carrier_name)
    {
        $this->tracking_info['carrier_name'] = $carrier_name;
        Order::where('order_id', $this->order_id)->update([
            'tracking' => json_encode($this->tracking_info),
            'status' => "In-Transit",
        ]);
        $this->order_status = "In-Transit";
        $this->toggleTrackingForm(false);
        $this->is_tracking_set = true;
    }

    public function combineProducts()
    {
        $this->packProducts(true);
    }

    public function calulateIncomingTotal()
    {
        if (!isset($this->current_product['units']) || !(int)$this->current_product['units']) {
            $this->current_product['units'] = 1;
        }
        if (!isset($this->current_product['qty']) || !(int)$this->current_product['qty']) {
            $this->current_product['qty'] = 0;
        }
        $this->incoming_total_items = (int)$this->current_product['qty'] * (int)$this->current_product['units'];

        if (isset($this->outgoing_product['isValid']) && $this->outgoing_product['isValid']) {
            if (!(int)$this->outgoing_product['units']) {
                $this->outgoing_product['units'] = 1;
            }
            $this->outgoing_product['qty'] = floor($this->incoming_total_items / (int)$this->outgoing_product['units']);
            $this->current_product['remaining_qty'] = $this->incoming_total_items % (int)$this->outgoing_product['units'];
        }
    }

    public function resetProductForm()
    {
        $this->current_product = null;
        $this->outgoing_product = null;
        $this->editing_product = null;
        $this->incoming_total_items = 0;
    }

    public function clearIncomingItems()
    {
        $this->current_product['incoming_package_items'] = null;
        $this->generateTotals();
    }

    public function countSKULabels()
    {
        $this->sku_label_count = 0;
        foreach ($this->products as $product) {
            if (isset($product['label_file'])) {
                $this->sku_label_count += 1;
            }
        }
    }

    public function setCurrentStep($step)
    {
        if ($this->currentStep > $step && $this->currentStep != 7) {
            $this->currentStep = $step;
            $this->emit('setCounterChanged', $this->currentStep);
        }
    }

    public function incrementStepCounter(ImpInterface $ki)
    {

        switch ($this->currentStep) {
            case 0: {
                    if ($this->products_exported && count($this->products) == 0) {
                        foreach ($this->products_exported as $exp_product) {
                            if ($exp_product['bundle'] == 'none' || $exp_product['bundle'] == null) {
                                $product_details = $this->searchASINDatabase($exp_product, $ki);
                                if ($product_details['success']) {
                                    $this->addProduct($product_details['product']);
                                }
                            } else {
                                $product_details = $this->searchASINDatabase($exp_product, $ki);
                                if ($product_details['success']) {
                                    $incoming_product_details = $this->searchASINDatabase($exp_product['incoming_product'], $ki);
                                    if ($incoming_product_details['success']) {
                                        $product_bundled = $product_details['product'];
                                        $product_bundled['incoming_product'] = $incoming_product_details['product'];
                                        $this->addProduct($product_bundled);
                                    }
                                }
                            }
                        }
                    }
                    $this->currentStep += 1;
                    $this->emit('setCounterChanged', $this->currentStep);
                    break;
                }
            case 1: {
                    $this->packProducts();
                    break;
                }
            case 2: {
                    $this->generateServices();
                    break;
                }
            case 4: {
                    $this->countSKULabels();
                    $this->selectWarehouses();
                    break;
                }
            case 5: {
                    $this->setShippingAddress();
                    break;
                }
            case 6: {
                    $this->createOrder();
                    break;
                }
            default: {
                    $this->currentStep += 1;
                    $this->emit('setCounterChanged', $this->currentStep);
                    break;
                }
        }
    }

    public function clearShippingAddress()
    {
        $this->shipping_address = null;
    }

    public function setShippingAddress($update = false)
    {
        if ($this->add_shipping_details_later) {
            $this->shipping_address = null;
        } else {
            if ($this->fba_warehouse_select) {
                foreach ($this->warehouses as $warehouse) {
                    if ($warehouse->id == $this->shipping_address['warehouse_id']) {
                        $this->shipping_address['warehouse_id'] = $warehouse->id;
                        $this->shipping_address['name'] = $warehouse->name;
                        $this->shipping_address['company'] = $warehouse->company;
                        $this->shipping_address['phone'] = $warehouse->phone;
                        $this->shipping_address['email'] = $warehouse->email;
                        $this->shipping_address['country'] = $warehouse->country;
                        $this->shipping_address['zip'] = $warehouse->zip;
                        $this->shipping_address['city'] = $warehouse->city;
                        $this->shipping_address['state'] = $warehouse->state;
                        $this->shipping_address['address_1'] = $warehouse->address_1;
                        $this->shipping_address['address_2'] = $warehouse->address_2;
                        break;
                    }
                }
            } else {
                $this->shipping_address['warehouse_id'] = null;
            }
        }
        if (!$update) {
            $this->currentStep += 1;
            $this->emit('setCounterChanged', $this->currentStep);
        }
    }

    public function selectWarehouses()
    {
        $selected_country = null;
        foreach ($this->countries as $country) {
            if ($country->id == $this->country_id) {
                $selected_country = $country->name;
                break;
            }
        }
        $this->warehouses = Warehouse::where('country', $selected_country)->get();
        $this->currentStep += 1;
        $this->emit('setCounterChanged', $this->currentStep);
    }

    public function decrementStepCounter()
    {
        $this->currentStep -= 1;
        $this->emit('setCounterChanged', $this->currentStep);
    }

    public function addProduct($selected_product = null)
    {
        if (!$selected_product) {
            if (isset($this->current_product['bundle']) && $this->current_product['bundle'] !== 'none') {
                $selected_product = $this->outgoing_product;
                $product_item = $this->current_product;
                unset($product_item['notes']);
                $selected_product['incoming_product'] = $product_item;
                $selected_product['bundle'] = $this->current_product['bundle'];
                if (isset($this->current_product['notes'])) {
                    $selected_product['notes'] = $this->current_product['notes'];
                }
            } else {
                $selected_product = $this->current_product;
            }
        }

        $oversize = 0;
        if ($selected_product['width'] > 90 || $selected_product['height'] > 90 || $selected_product['length'] > 90) {
            $oversize = 100;
        } else if ($selected_product['width'] > 45 || $selected_product['height'] > 45 || $selected_product['length'] > 45) {
            $oversize = 50;
        } else if (
            ($selected_product['width']  > 30 && $selected_product['height'] > 30) ||
            ($selected_product['width']  > 30 && $selected_product['length'] > 30) ||
            ($selected_product['length'] > 30 && $selected_product['height'] > 30)
        ) {
            $oversize = 50;
        }

        $price_ratios = WarehousePriceRatio::where('country_id', $this->country_id)
            ->where('min_price', '<=', $selected_product['price'])
            ->where('max_price', '>=', $selected_product['price'])
            ->first();
        $price_ratio = $selected_product['price'] * $price_ratios->price_ratio;

        $tax_ratio = WarehouseRatio::where('country_id', $this->country_id)
            ->where('min_price', '<=', $price_ratio)
            ->where('max_price', '>=', $price_ratio)
            ->first();
        $tax_ratio = $tax_ratio === null ? 0 : $tax_ratio['tax_ratio'];
        $tax_ratio = $price_ratio * $tax_ratio;

        $selected_product['import_fee'] = $oversize + $tax_ratio;

        if (isset($this->current_product['editIndex'])) {
            unset($this->products[$this->current_product['editIndex']]);
        }

        array_push($this->products, $selected_product);
        $this->generateTotals();
        $this->resetProductForm();
        $this->emit('setCurrentProduct', null);
    }

    public function removeProduct($index)
    {
        unset($this->products[$index]);
        $this->generateTotals();
    }

    public function serviceUpdate($value = '', $id = '')
    {
        $total_price = 0;
        $value = $value ? $value : 0;
        foreach ($this->services as $index => $service) {
            if ($service['id'] == $id) {
                $this->services[$index]['qty'] = $value;
                $this->services[$index]['total'] = $service['price'] * $value;
                $total_price += $service['price'] * $value;
            } else {
                $total_price += $service['total'];
            }
        }
        $this->order_total = $total_price;
    }

    public function updateServices()
    {
        $order_total = 0;
        $this->services = [];

        foreach ($this->servicesDB as $service) {
            $data["id"] = $service->id;
            $data["name"] = $service->name;
            $data["description"] = $service->description;
            if (isset($this->user_services[$service->id])) {
                $data['price'] = floatval($this->user_services[$service->id]);
            } else {
                $data['price'] = $service->price;
            }
            $data["disabled"] = false;

            if ($service->type == 'fixed') {
                $data["qty"] = 1;
            } else {
                if ($service->dependency == 'boxes') {
                    $data["qty"] = count($this->bins);
                } else if ($service->dependency == 'products') {
                    $data["qty"] = 0;
                    foreach ($this->products as $product) {
                        $data["qty"] += $product["qty"];
                    }
                } else if ($service->dependency == 'incoming_packages') {
                    $data["qty"] = 0;
                    foreach ($this->products as $product) {
                        if (isset($product['bundle']) && $product['bundle'] !== 'none') {
                            $data["qty"] += $product["incoming_product"]["qty"];
                        } else {
                            $data["qty"] += $product["qty"];
                        }
                    }
                } else if ($service->dependency == 'outgoing_packages') {
                    $data["qty"] = 0;
                    foreach ($this->products as $product) {
                        $data["qty"] += $product["qty"];
                    }
                }
            }

            $data["total"] = $data['price'] * $data["qty"];
            $order_total += $data["total"];
            array_push($this->services, $data);
        }

        $total_outgoing_products = 0;
        foreach ($this->products as $product) {
            $total_outgoing_products += $product["qty"];
        }

        if ($this->carrier_selected) {
            $data["id"] = 'SHIPPING';
            $data["name"] = "Shipping Fee";
            $data["description"] = "";
            $data["price"] = $this->carriers[$this->carrier_selected]['shipping_fee'];
            $data["disabled"] = true;
            $data["qty"] = 1;
            $data["total"] = $this->carriers[$this->carrier_selected]['shipping_fee'];
            $order_total += $data["total"];
            array_push($this->services, $data);

            $data["id"] = 'DISCOUNT';
            $data["name"] = "Shipping Fee Discount (" . $this->discount . "%)";
            $data["description"] = "";
            $data["price"] = $this->carriers[$this->carrier_selected]['shipping_fee'] - ($this->carriers[$this->carrier_selected]['shipping_fee'] * ((100 - $this->discount) / 100));
            $data["disabled"] = true;
            $data["qty"] = 1;
            $data["total"] = $this->carriers[$this->carrier_selected]['shipping_fee'] - ($this->carriers[$this->carrier_selected]['shipping_fee'] * ((100 - $this->discount) / 100));
            $order_total -= $data["total"];
            array_push($this->services, $data);

            $data["id"] = 'TAXANDDUTY';
            $data["name"] = "Total Import Tax & Duty Charge";
            $data["description"] = "";
            $data["price"] = $this->carriers[$this->carrier_selected]['import_fee'];
            $data["disabled"] = true;
            $data["qty"] = 1;
            $data["total"] = $this->carriers[$this->carrier_selected]['import_fee'];
            $order_total += $data["total"];
            array_push($this->services, $data);

            $data["id"] = 'INSURANCE';
            $data["name"] = "Insurance Charge";
            $data["description"] = "";
            $data["disabled"] = true;
            $data["price"] = 0;
            $data["qty"] = 0;
            $data["total"] = 0;
            foreach ($this->bins as $bin) {
                if ($bin['insurance_selected']) {
                    $data["qty"] += 1;
                    $data["price"] += $bin['insurance_price'];
                    $data["total"] += $bin['insurance_price'];
                    $order_total += $bin['insurance_price'];
                }
            }
            array_push($this->services, $data);
        }

        $this->order_total = $order_total;
    }

    public function generateServices()
    {
        $this->updateServices();
        $this->currentStep += 1;
        $this->emit('setCounterChanged', $this->currentStep);
    }

    public function resetParams()
    {
        $this->products_not_packed = [];
        $this->bins = [];
        $carriers = Carrier::all();
        foreach ($this->carriers as $index => $carrier) {
            unset($this->carriers[$index]);
        }
        foreach ($carriers as $carrier) {
            $data['id'] = $carrier->id;
            $data['name'] = $carrier->name;
            $data['logo'] = $carrier->logo;
            $data['shipping_fee'] = 0;
            $data['import_fee'] = 0;
            $data['total_fee'] = 0;
            $this->carriers[$carrier->id] = $data;
        }
        $this->carrier_selected = null;
    }


    public function packProducts($combine = false)
    {
        $this->resetParams();

        $BOX_LIST = [];
        $ITEM_LIST = [];

        $boxes = Box::all();
        $country_selected_name = Country::find($this->country_id)->name;

        foreach ($boxes as $box) {
            $data["id"] = $box->id;
            $data["w"] = $box->width;
            $data["d"] = $box->length;
            $data["h"] = $box->height;
            $data["wg"] = $box->weight;
            $data["max_wg"] = 50 - $box->weight;
            if ($country_selected_name == 'United States') {
                $data["limit_per_bin"] = '150';
            }
            array_push($BOX_LIST, $data);
        }
        $BOX_LIST = json_encode($BOX_LIST);

        foreach ($this->products as $product) {
            $data["id"] = $product['asin'];
            $data["q"] = $product['qty'];
            $data["w"] = $product['width'];
            $data["d"] = $product['length'];
            $data["h"] = $product['height'];
            $data["wg"] = $product['a_weight'];
            $data["vr"] = '1';
            $data["separate"] = !$this->combine_products;
            array_push($ITEM_LIST, $data);
        }

        $ITEM_LIST = json_encode($ITEM_LIST);

        $data = array(
            'bins' => json_decode($BOX_LIST, true),
            'items' => json_decode($ITEM_LIST, true),
            'username' => env('3DBIN_PACKING_USERNAME'),
            'api_key' => env('3DBIN_PACKING_API_KEY'),
            'params' => array(
                'images_background_color' => '0,158,247',
                'images_bin_border_color' => '59,59,59',
                'images_bin_fill_color' => '240,250,255',
                'images_item_border_color' => '240,250,255',
                'images_item_fill_color' => '235,171,84',
                'images_item_back_border_color' => '22,22,22',
                'images_sbs_last_item_fill_color' => '177,14,14',
                'images_sbs_last_item_border_color' => '22,22,22',
                'images_format' => 'svg',
                'images_width' => '100',
                'images_height' => '100',
                'images_source' => 'file',
                'stats' => '0',
                'item_coordinates' => '1',
                'images_complete' => '1',
                'images_sbs' => '1',
                'images_separated' => '1',
                'optimization_mode' => 'bins_number',
            )
        );
        $query = json_encode($data);

        $url = "https://global-api.3dbinpacking.com/packer/packIntoMany";
        $prepared_query = 'query=' . $query;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $prepared_query);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $resp = curl_exec($ch);
        if (curl_errno($ch)) {
            $output_response['success'] = false;
            $output_response['data'] = 'Error #' . curl_errno($ch) . ': ' . curl_error($ch) . '<br>';
        }
        curl_close($ch);

        $response = json_decode($resp, true);

        if ($response['response']['status'] == 1) {
            $response_data = $response['response'];

            foreach ($response_data['not_packed_items'] as $unpacked_item) {
                foreach ($this->products as $index => $product) {
                    if ($unpacked_item['id'] == $product['asin'] && $unpacked_item['wg'] == $product['a_weight']) {
                        array_push($this->products_not_packed, $product);
                        unset($this->products[$index]);
                        break;
                    }
                }
            }

            foreach ($response_data['bins_packed'] as $bin) {
                $bin_data = $bin['bin_data'];
                $bin_data['name'] = Box::find($bin['bin_data']['id'])->name;
                $bin_data['image'] = $bin['image_complete'];
                $bin_data['products'] = [];
                $bin_data['import_fee'] = 0;
                $bin_data['total_price'] = 0;

                $bin_data['total_products'] = count($bin['items']);
                $bin_data['insurance_selected'] = false;
                $bin_data['insurance_price'] = 0;

                $deci_weight = ($bin_data['w'] * $bin_data['h'] * $bin_data['d']) / 139;
                $unit_weight = $bin_data['gross_weight'];
                $base_weight = $deci_weight > $unit_weight ? $deci_weight : $unit_weight;
                $bin_data['base_weight'] = round($base_weight);

                foreach ($bin['items'] as $added_product) {
                    if (isset($bin_data['products'][$added_product['id']])) {
                        $bin_data['products'][$added_product['id']]['qty'] += 1;
                    } else {
                        $bin_data['products'][$added_product['id']]['qty'] = 1;
                        foreach ($this->products as $product) {
                            if ($product['asin'] === $added_product['id']) {
                                $bin_data['products'][$added_product['id']]['price'] = $product['price'];
                                $bin_data['products'][$added_product['id']]['import_fee'] = $product['import_fee'];
                                break;
                            }
                        }
                    }
                }

                foreach ($bin_data['products'] as $product_id => $product) {
                    $bin_data['total_price'] += $product['price'] * $product['qty'];
                    $bin_data['import_fee'] += $product['import_fee'] * $product['qty'];
                }

                $insurance = Insurance::where('min_qty', '<=', $bin_data['total_products'])
                    ->where('max_qty', '>=', $bin_data['total_products'])
                    ->first();
                $bin_data['insurance_price'] = $insurance->price;

                array_push($this->bins, $bin_data);
            }

            $this->generateTotals();
            $this->calculateCarrierFee();

            if (!$combine) {
                $this->currentStep += 1;
                $this->emit('setCounterChanged', $this->currentStep);
            }
        } else {
            $errors = "";
            foreach ($response['response']['errors'] as $error) {
                $errors .= $error['message'] . '<br>';
            }
            $this->emit('binPackingError', $errors);
        }
    }


    public function calculateCarrierFee()
    {
        foreach ($this->bins as $bin_index => $bin_data) {

            $rate_ratios = WarehouseRateRatio::where('country_id', $this->country_id)
                ->where('weight', '=', $bin_data['base_weight'])
                ->orderBy("price", "ASC")
                ->get();

            $this->bins[$bin_index]['carriers'] = [];

            foreach ($this->carriers as $index => $carrier) {
                $carrier_exists = false;
                foreach ($rate_ratios as $ratio) {
                    if ($ratio->carrier_id == $carrier['id']) {
                        $this->carriers[$index]['shipping_fee'] += $ratio->price;
                        $this->carriers[$index]['import_fee'] += $bin_data['import_fee'];
                        $this->carriers[$index]['total_fee'] += ($ratio->price + $bin_data['import_fee']);
                        $this->bins[$bin_index]['carriers'][$index]['shipping_fee'] = $ratio->price;
                        $this->bins[$bin_index]['carriers'][$index]['total_fee'] = ($ratio->price + $bin_data['import_fee']);

                        $carrier_exists = true;
                        break;
                    }
                }
                if (!$carrier_exists) {
                    unset($this->carriers[$index]);
                }
            }
        }
    }

    public function generateTotals()
    {
        $data["totalWeight"] = 0;
        $data["totalDeci"] = 0;
        $data["totalPrice"] = 0;
        $data["totalQty"] = 0;
        $this->product_count = 0;
        foreach ($this->products as $key => $product) {
            $this->product_count += $product['qty'];
            $data["totalWeight"] += $product['a_weight'] * $product['qty'];
            $data["totalDeci"] += $product['d_weight'] * $product['qty'];
            $data["totalPrice"] += $product['price'] * $product['qty'];
            $data["totalQty"] += $product['qty'];
        }
        $this->totalPrice = $data["totalPrice"];
        $this->totalWeight = $data["totalWeight"];
        $this->totalDeci = $data["totalDeci"];
        return $data;
    }

    public function uploadLabels()
    {
        $success = true;
        try {
            foreach ($this->products as $index => $product) {
                if (isset($product["label_file"])) {
                    $product_label = Storage::disk('s3')->put('orders/' . $this->order_id . '/labels', $product['label_file']);
                    $this->products[$index]["label_file"] = $product_label;
                }
            }
            if ($this->fnsku_labels) {
                foreach ($this->fnsku_labels as $label) {
                    $fnsku_label = Storage::disk('s3')->put('orders/' . $this->order_id . '/labels', $label);
                    array_push($this->fnsku_labels_arr, $fnsku_label);
                }
            }
            if ($this->fba_labels) {
                foreach ($this->fba_labels as $label) {
                    $fba_label = Storage::disk('s3')->put('orders/' . $this->order_id . '/fbalabels', $label);
                    array_push($this->fba_labels_arr, $fba_label);
                }
            }
        } catch (Exception $e) {
            $success = false;
        }
        return $success;
    }


    public function createOrder()
    {
        $inventory_products = [];

        foreach ($this->products as $product) {
            if (isset($product['bundle']) && $product['bundle'] !== 'none') {
                $product = $product['incoming_product'];
            }

            if (isset($inventory_products[$product['asin']])) {
                $inventory_products[$product['asin']]['working'] += $product['qty'];
                $inventory_products[$product['asin']]['total'] += $product['qty'];
            } else {
                $inventory_products[$product['asin']]['asin'] = $product['asin'];
                $inventory_products[$product['asin']]['working'] = $product['qty'];
                $inventory_products[$product['asin']]['total'] = $product['qty'];
                $inventory_products[$product['asin']]['customer_id'] = $this->user->id;
                $inventory_products[$product['asin']]['type'] = 'outgoing';
            }
        }

        $incoming_product_map = [];
        $outgoing_product_map = [];
        foreach ($this->products as $product) {
            $outgoing_product = $product;
            if (isset($product['bundle']) && $product['bundle'] !== 'none') {
                $incoming_product = $product['incoming_product'];
                $incoming_product['bundle'] = $product['bundle'];
                $outgoing_product['bundle'] = $product['bundle'];
            } else {
                $incoming_product = $product;
            }

            if (isset($incoming_product_map[$incoming_product['asin']])) {
                $incoming_product_map[$incoming_product['asin']]['total'] += $incoming_product['qty'];
                $incoming_product_map[$incoming_product['asin']]['received'] += $this->is_express ? 0 : $incoming_product['qty'];
            } else {
                $incoming_product_map[$incoming_product['asin']]['asin'] = $incoming_product['asin'];
                $incoming_product_map[$incoming_product['asin']]['total'] = $incoming_product['qty'];
                $incoming_product_map[$incoming_product['asin']]['received'] = $this->is_express ? 0 : $incoming_product['qty'];
                $incoming_product_map[$incoming_product['asin']]['damaged'] = 0;
            }

            if (isset($outgoing_product_map[$outgoing_product['asin']])) {
                $outgoing_product_map[$outgoing_product['asin']]['total'] += $outgoing_product['qty'];
            } else {
                $outgoing_product_map[$outgoing_product['asin']]['asin'] = $outgoing_product['asin'];
                $outgoing_product_map[$outgoing_product['asin']]['total'] = $outgoing_product['qty'];
                $outgoing_product_map[$outgoing_product['asin']]['shipped'] = 0;
                $outgoing_product_map[$outgoing_product['asin']]['damaged'] = 0;
            }
        }
        $product_map['incoming'] = $incoming_product_map;
        $product_map['outgoing'] = $outgoing_product_map;

        $export_bins = $this->bins;
        foreach ($export_bins as $index => $bin) {
            $export_bins[$index]['shipping_fee'] = $export_bins[$index]['carriers'][$this->carrier_selected]['shipping_fee'];
            unset($export_bins[$index]['carriers']);
        }

        if ($this->uploadLabels()) {
            $order = Order::create([
                'order_id' => $this->order_id,
                'customer_id' => $this->user->id,
                'country_id' => $this->country_id,
                'products_map' => json_encode($product_map),
                'products' => json_encode($this->products),
                'boxes' => json_encode($export_bins),
                'carriers' => json_encode($this->carriers[$this->carrier_selected]),
                'services' => json_encode($this->services),
                'fnsku_labels' => json_encode($this->fnsku_labels_arr),
                'fba_labels' => json_encode($this->fba_labels_arr),
                'shipping_address' => json_encode($this->shipping_address),
                'product_count' => $this->product_count,
                'received_product_count' => $this->is_express ? 0 : $this->product_count,
                'total' => $this->order_total,
                'is_express' => $this->is_express,
                'status' => $this->is_express ? 'Submitted' : 'Received',
            ]);

            if ($order) {

                if (!$this->is_express) {
                    foreach ($inventory_products as $index => $inventory_product) {
                        $inventory_products[$index]['ref_id'] = $order->id;
                        $inventory_products[$index]['created_at'] = date('Y-m-d H:i:s');
                        $inventory_products[$index]['updated_at'] = date('Y-m-d H:i:s');
                    }
                    $inventory_products_db = array_values($inventory_products);
                    Inventory::insert($inventory_products_db);
                }

                $this->order_id_generated = ($this->is_express ? 'E' : 'I') . 'FBA' . str_pad($order->id, 5, "0", STR_PAD_LEFT);

                //Send email to user here....
                $details = [
                    'customer_name' => $this->user->first_name,
                    'order_id' => $this->order_id_generated,
                    'products' => json_encode($inventory_products),
                    'amount' => $this->order_total,
                ];
                Mail::to($this->user->email)->send(new \App\Mail\OrderPlacedMail($details));

                $this->currentStep += 1;
                $this->emit('setCounterChanged', $this->currentStep);
                $this->order_status
                    = $this->is_express ? 'Submitted' : 'Received';
            }
        }
    }

    public function editProduct($index)
    {
        if (isset($this->products[$index]['bundle']) && $this->products[$index]['bundle'] !== 'none') {
            $this->outgoing_product = $this->products[$index];
            $this->editing_product = $this->products[$index];
            $this->current_product = $this->products[$index]['incoming_product'];
            if (isset($this->outgoing_product['notes']) && !empty($this->outgoing_product['notes'])) {
                $this->current_product['notes'] = $this->outgoing_product['notes'];
                unset($this->outgoing_product['notes']);
            }
        } else {
            $this->current_product = $this->products[$index];
            $this->editing_product = $this->products[$index];
        }

        $this->current_product['isValid'] = true;
        $this->current_product['editIndex'] = $index;

        $this->emit('setCurrentProduct', $this->current_product);
    }

    public function discardProductChanges()
    {
        $this->resetProductForm();
    }

    public function clearProduct()
    {
        $this->resetProductForm();
    }

    public function clearOutgoingProduct()
    {
        $this->outgoing_product = null;
    }


    public function searchProduct(ImpInterface $ki)
    {
        $product_found = false;
        // Search in database for the product
        $db_product = Product::where('asin', $this->current_product['asin'])->where('user_id', Auth::user()->id)->first();
        $this->current_product['isValid'] = false;
        if ($db_product) {
            $this->current_product['title'] = $db_product['title'];
            $this->current_product['image'] = Storage::disk('s3')->url($db_product['image']);
            $this->current_product['price'] = $db_product['price'];
            $this->current_product['length'] = $db_product['length'];
            $this->current_product['width'] = $db_product['width'];
            $this->current_product['height'] = $db_product['height'];
            $this->current_product['a_weight'] = $db_product['weight'];
            $this->current_product['d_weight'] = $db_product['weight'];
            $this->current_product['units'] = $db_product['items'];
            $this->current_product['isValid'] = true;
            $this->current_product['bundle'] = isset($this->current_product['bundle']) ? $this->current_product['bundle'] : "none";

            $product_found = true;
        }

        if (!$product_found) {
            // Search for product on Keepa Amazon
            $keepa = $ki->find($this->current_product['asin']);
            if ($keepa) {
                $this->current_product['title'] = $keepa['title'];
                $this->current_product['image'] = $keepa['image'];
                $this->current_product['price'] = $keepa['price'];
                $this->current_product['length'] = $keepa['length'];
                $this->current_product['width'] = $keepa['width'];
                $this->current_product['height'] = $keepa['height'];
                $this->current_product['a_weight'] = $keepa['weight'];
                $this->current_product['d_weight'] = $keepa['d_weight'];
                $this->current_product['units'] = $keepa['items'];
                $this->current_product['isValid'] = true;
                $this->current_product['bundle'] = isset($this->current_product['bundle']) ? $this->current_product['bundle'] : "none";

                $product_found = true;
            }
        }
        if ($product_found) {
            $this->emit('setCurrentProduct', $this->current_product);
        } else {
            $this->emit('setCurrentProduct', null);
        }
        return $product_found;
    }

    public function searchOutgoingProduct(ImpInterface $ki)
    {
        $product_found = false;
        // Search in database for the product
        $db_product = Product::where('asin', $this->outgoing_product['asin'])->where('user_id', Auth::user()->id)->first();
        $this->outgoing_product['isValid'] = false;
        if ($db_product) {
            $this->outgoing_product['title'] = $db_product['title'];
            $this->outgoing_product['image'] = Storage::disk('s3')->url($db_product['image']);
            $this->outgoing_product['price'] = $db_product['price'];
            $this->outgoing_product['length'] = $db_product['length'];
            $this->outgoing_product['width'] = $db_product['width'];
            $this->outgoing_product['height'] = $db_product['height'];
            $this->outgoing_product['a_weight'] = $db_product['weight'];
            $this->outgoing_product['d_weight'] = $db_product['weight'];
            $this->outgoing_product['units'] = $db_product['items'];
            $this->outgoing_product['qty'] = isset($this->current_product['qty']) && isset($this->current_product['units']) ? (($this->current_product['qty'] * $this->current_product['units']) / $this->outgoing_product['units']) : null;
            $this->outgoing_product['isValid'] = true;

            $product_found = true;
        }

        if (!$product_found) {
            // Search for product on Keepa Amazon
            $keepa = $ki->find($this->outgoing_product['asin']);
            if ($keepa) {
                $this->outgoing_product['title'] = $keepa['title'];
                $this->outgoing_product['image'] = $keepa['image'];
                $this->outgoing_product['price'] = $keepa['price'];
                $this->outgoing_product['length'] = $keepa['length'];
                $this->outgoing_product['width'] = $keepa['width'];
                $this->outgoing_product['height'] = $keepa['height'];
                $this->outgoing_product['a_weight'] = $keepa['weight'];
                $this->outgoing_product['d_weight'] = $keepa['d_weight'];
                $this->outgoing_product['units'] = $keepa['items'];
                $this->outgoing_product['qty'] = isset($this->current_product['qty']) && isset($this->current_product['units']) ? (($this->current_product['qty'] * $this->current_product['units']) / $this->outgoing_product['units']) : null;
                $this->outgoing_product['isValid'] = true;

                $product_found = true;
            }
        }
        return $product_found;
    }

    public function searchASINDatabase($product, $ki)
    {
        $data['success'] = false;
        // Search in database for the product
        $db_product = Product::where('asin', $product['asin'])->where('user_id', Auth::user()->id)->first();
        $product['isValid'] = false;
        if ($db_product) {
            $product['title'] = $db_product['title'];
            $product['image'] = env('APP_URL') . '/' . 'storage/' . $db_product['image'];
            $product['price'] = $db_product['price'];
            $product['length'] = $db_product['length'];
            $product['width'] = $db_product['width'];
            $product['height'] = $db_product['height'];
            $product['a_weight'] = $db_product['weight'];
            $product['d_weight'] = $db_product['weight'];
            $product['isValid'] = true;

            $data['product'] = $product;
            $data['success'] = true;
        }

        if (!$data['success']) {
            // Search for product on Keepa Amazon
            $keepa = $ki->find($product['asin']);
            if ($keepa) {
                $product['title'] = $keepa['title'];
                $product['image'] = $keepa['image'];
                $product['price'] = $keepa['price'];
                $product['length'] = $keepa['length'];
                $product['width'] = $keepa['width'];
                $product['height'] = $keepa['height'];
                $product['a_weight'] = $keepa['weight'];
                $product['d_weight'] = $keepa['d_weight'];
                $product['isValid'] = true;

                $data['product'] = $product;
                $data['success'] = true;
            }
        }

        return $data;
    }

    public function resetBundling()
    {
        if ($this->current_product["bundle"] == "none") {
            $this->outgoing_product = null;
        }
    }
}