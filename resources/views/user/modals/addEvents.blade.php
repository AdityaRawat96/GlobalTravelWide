  <!--begin::Modal - New Product-->
  <div class="modal fade" id="kt_modal_add_event" tabindex="-1" aria-hidden="true">
      <!--begin::Modal dialog-->
      <div class="modal-dialog modal-dialog-centered mw-650px">
          <!--begin::Modal content-->
          <div class="modal-content">
              <!--begin::Form-->
              <form class="form" action="{{route(Auth::user()->role . '.user.updateAttendance', $user->id)}}"
                  id="kt_create_form" method="POST">
                  @csrf
                  <!--begin::Modal header-->
                  <div class="modal-header">
                      <!--begin::Modal title-->
                      <h2 class="fw-bold" data-kt-calendar="title">Add Event</h2>
                      <!--end::Modal title-->
                      <!--begin::Close-->
                      <div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_event_close">
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                          <span class="svg-icon svg-icon-1">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                  xmlns="http://www.w3.org/2000/svg">
                                  <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                      transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                  <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                      fill="currentColor" />
                              </svg>
                          </span>
                          <!--end::Svg Icon-->
                      </div>
                      <!--end::Close-->
                  </div>
                  <!--end::Modal header-->
                  <!--begin::Modal body-->
                  <div class="modal-body py-10 px-lg-17">
                      <!--begin::Input group-->
                      <div class="fv-row mb-9">
                          <!--begin::Label-->
                          <label class="fs-6 fw-semibold mb-2">Event Name</label>
                          <!--end::Label-->
                          <!--begin::Input-->
                          <input type="text" class="form-control form-control-solid" placeholder=""
                              name="calendar_event_name" />
                          <!--end::Input-->
                      </div>
                      <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="row row-cols-lg-2 g-10">
                          <div class="col">
                              <div class="fv-row mb-9">
                                  <!--begin::Label-->
                                  <label class="fs-6 fw-semibold mb-2">Event Start
                                      Date</label>
                                  <!--end::Label-->
                                  <!--begin::Input-->
                                  <input class="form-control form-control-solid" name="calendar_event_start_date"
                                      placeholder="Pick a start date" id="kt_calendar_datepicker_start_date" disabled />
                                  <!--end::Input-->
                              </div>
                          </div>
                          <div class="col" data-kt-calendar="datepicker">
                              <div class="fv-row mb-9">
                                  <!--begin::Label-->
                                  <label class="fs-6 fw-semibold mb-2 required">Event Start Time</label>
                                  <!--end::Label-->
                                  <!--begin::Input-->
                                  <input class="form-control form-control-solid" name="calendar_event_start_time"
                                      placeholder="Pick a start time" id="kt_calendar_datepicker_start_time" />
                                  <!--end::Input-->
                              </div>
                          </div>
                      </div>
                      <!--end::Input group-->
                      <!--begin::Input group-->
                      <div class="row row-cols-lg-2 g-10">
                          <div class="col">
                              <div class="fv-row mb-9">
                                  <!--begin::Label-->
                                  <label class="fs-6 fw-semibold mb-2">Event End Date</label>
                                  <!--end::Label-->
                                  <!--begin::Input-->
                                  <input class="form-control form-control-solid" name="calendar_event_end_date"
                                      placeholder="Pick a end date" id="kt_calendar_datepicker_end_date" disabled />
                                  <!--end::Input-->
                              </div>
                          </div>
                          <div class="col" data-kt-calendar="datepicker">
                              <div class="fv-row mb-9">
                                  <!--begin::Label-->
                                  <label class="fs-6 fw-semibold mb-2 required">Event End Time</label>
                                  <!--end::Label-->
                                  <!--begin::Input-->
                                  <input class="form-control form-control-solid" name="calendar_event_end_time"
                                      placeholder="Pick a end time" id="kt_calendar_datepicker_end_time" />
                                  <!--end::Input-->
                              </div>
                          </div>
                      </div>
                      <!--end::Input group-->
                  </div>
                  <!--end::Modal body-->
                  <!--begin::Modal footer-->
                  <div class="modal-footer flex-center">
                      <!--begin::Button-->
                      <button type="reset" id="kt_modal_add_event_cancel" class="btn btn-light me-3">Cancel</button>
                      <!--end::Button-->
                      <!--begin::Button-->
                      <button type="button" id="kt_form_submit" class="btn btn-primary">
                          <span class="indicator-label">Submit</span>
                          <span class="indicator-progress">Please wait...
                              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                      </button>
                      <!--end::Button-->
                  </div>
                  <!--end::Modal footer-->
              </form>
              <!--end::Form-->
          </div>
      </div>
  </div>
  <!--end::Modal - New Product-->