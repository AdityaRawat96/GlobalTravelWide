  <!--begin::Item template-->
  <div class="d-none" data-kt-element="airline-template">
      <div class="border-bottom border-bottom-dashed d-flex flex-row mt-5" data-kt-element="airline">
          <div class="flex-1 w-100">
              <div class="row">
                  <div class="col-md-12 col-lg-6">
                      <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Airline
                          name</label>
                      <div class="mb-5 fv-row">
                          <input type="text" class="form-control form-control-solid" placeholder="Airline Name"
                              name="airline_name[]" />
                          <div class="fv-plugins-message-container invalid-feedback">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12 col-lg-6">
                      <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Departure and Arrival
                          time</label>
                      <input class="form-control form-control-solid airline_time datetimepicker-input"
                          placeholder="Pick date range" name="airline_time[]" />
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12 col-lg-6">
                      <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Arrival
                          airport</label>
                      <div class="mb-5 fv-row">
                          <input type="text" class="form-control form-control-solid" placeholder="Airport Name"
                              name="arrival_airport[]" />
                          <div class="fv-plugins-message-container invalid-feedback">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12 col-lg-6">
                      <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Departure
                          airport</label>
                      <div class="mb-5 fv-row">
                          <input type="text" class="form-control form-control-solid" placeholder="Airport Name"
                              name="departure_airport[]" />
                          <div class="fv-plugins-message-container invalid-feedback">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div>
              <button type="button" class="btn btn-icon btn-active-color-primary mt-5" data-kt-element="remove-airline">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                  <span class="svg-icon svg-icon-3">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                              d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                              fill="currentColor" />
                          <path opacity="0.5"
                              d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                              fill="currentColor" />
                          <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                              fill="currentColor" />
                      </svg>
                  </span>
                  <!--end::Svg Icon-->
              </button>
          </div>
      </div>
  </div>
  <!--end::Item template-->
  <!--begin::Payment template-->
  <div class="d-none" data-kt-element="hotel-template">
      <div class="border-bottom border-bottom-dashed d-flex flex-row mt-5" data-kt-element="hotel">
          <div class="flex-1 w-100">
              <div class="row">
                  <div class="col-md-12 col-lg-6">
                      <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Hotel
                          name</label>
                      <div class="mb-5 fv-row">
                          <input type="text" class="form-control form-control-solid" placeholder="Hotel Name"
                              name="hotel_name[]" />
                          <div class="fv-plugins-message-container invalid-feedback">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12 col-lg-6">
                      <label class="form-label fs-6 fw-bold text-gray-700 mb-3 required">Check-In and Check-Out
                          time</label>
                      <input class="form-control form-control-solid hotel_time datetimepicker-input"
                          placeholder="Pick date range" name="hotel_time[]" />
                  </div>
              </div>
          </div>
          <div>
              <button type="button" class="btn btn-icon btn-active-color-primary mt-5" data-kt-element="remove-hotel">
                  <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                  <span class="svg-icon svg-icon-3">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                              d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                              fill="currentColor" />
                          <path opacity="0.5"
                              d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                              fill="currentColor" />
                          <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                              fill="currentColor" />
                      </svg>
                  </span>
                  <!--end::Svg Icon-->
              </button>
          </div>
      </div>
  </div>
  <!--end::Payment template-->
  <!--begin::Empty template-->
  <div class="d-none" data-kt-element="empty-template">
      <div class="w-100 text-center py-5 border-bottom border-bottom-dashed " data-kt-element="empty">
          <span class="text-muted text-center py-10">No items</span>
      </div>
  </div>
  <!--end::Empty template-->