"use strict";
var DIRECTORY_MAP = [
    {
        id: null,
        name: "Root",
        parent: null,
    },
];

// Create a variable to hold the Dropzone instance
let dropzoneInstance;
let DROPZONE_EVENTS_ADDED = false;

function backToParentDirectory() {
    if (DIRECTORY_MAP.length > 1) {
        DIRECTORY_MAP.pop();
        const parentDirectory = DIRECTORY_MAP[DIRECTORY_MAP.length - 1];
        KTFileManagerList.loadDirectoryContents(parentDirectory.id);
        updateDirectoryMap();
    }
}

function updateDirectoryMap() {
    const directoryMap = document.getElementById("file_tree_container");
    directoryMap.innerHTML = "";
    DIRECTORY_MAP.forEach((directory, index) => {
        const a = document.createElement("a");
        a.setAttribute("href", "#");
        a.setAttribute("data-id", directory.id);
        a.classList.add(
            "directory-route",
            "text-gray-800",
            "text-hover-primary"
        );
        a.innerText = directory.name;
        a.addEventListener("click", function (e) {
            e.preventDefault();
            DIRECTORY_MAP = DIRECTORY_MAP.slice(0, index + 1);
            KTFileManagerList.loadDirectoryContents(directory.id);
            updateDirectoryMap();
        });
        if (index === 0) {
            directoryMap.appendChild(a);
        } else {
            const svg = document.createElement("span");
            svg.classList.add(
                "svg-icon",
                "svg-icon-2",
                "svg-icon-primary",
                "mx-1"
            );
            svg.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor" />
            </svg>`;
            directoryMap.appendChild(svg);
            directoryMap.appendChild(a);
        }
    });
}
updateDirectoryMap();

var KTFileManagerList = (function () {
    var e, t, o, n, r, a;
    const l = () => {
            t.querySelectorAll(
                '[data-kt-filemanager-table-filter="delete_row"]'
            ).forEach((t) => {
                t.addEventListener("click", function (t) {
                    t.preventDefault();
                    let directory_item = t.target
                        .closest("tr")
                        .querySelector(".directory-item");
                    let attachment_id = directory_item
                        ? null
                        : t.target
                              .closest("tr")
                              .querySelector(".directory-file")
                              .getAttribute("data-id");
                    let directory_id = directory_item
                        ? directory_item.getAttribute("data-id")
                        : null;

                    let delete_url = directory_id
                        ? `/${siteUserRole}/directory/${directory_id}`
                        : `/${siteUserRole}/attachment/${attachment_id}`;
                    const o = t.target.closest("tr"),
                        n = o.querySelectorAll("td")[1].innerText;
                    Swal.fire({
                        text: "Are you sure you want to delete " + n + "?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (t) {
                        t.value
                            ? // AJAX to delete directory
                              $.ajax({
                                  url: delete_url,
                                  type: "DELETE",
                                  // add crsf token
                                  headers: {
                                      "X-CSRF-TOKEN": $(
                                          'meta[name="csrf-token"]'
                                      ).attr("content"),
                                  },
                                  success: function (res) {
                                      Swal.fire({
                                          text: n + " was deleted!",
                                          icon: "success",
                                          buttonsStyling: !1,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                              confirmButton:
                                                  "btn fw-bold btn-primary",
                                          },
                                      }).then(function () {
                                          // fetch the current directory contents
                                          KTFileManagerList.loadDirectoryContents(
                                              DIRECTORY_MAP[
                                                  DIRECTORY_MAP.length - 1
                                              ].id
                                          );
                                      });
                                  },
                                  error: function (t) {
                                      let error = t.responseJSON.error;
                                      Swal.fire({
                                          text: "Error: " + error,
                                          icon: "error",
                                          buttonsStyling: !1,
                                          confirmButtonText: "Ok, got it!",
                                          customClass: {
                                              confirmButton: "btn btn-primary",
                                          },
                                      });
                                  },
                              })
                            : "cancel" === t.dismiss &&
                              Swal.fire({
                                  text: n + " was not deleted.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              });
                    });
                });
            });
        },
        i = () => {
            var o = t.querySelectorAll('[type="checkbox"]');
            "folders" === t.getAttribute("data-kt-filemanager-table") &&
                (o = document.querySelectorAll(
                    '#kt_file_manager_list_wrapper [type="checkbox"]'
                ));
            const n = document.querySelector(
                '[data-kt-filemanager-table-select="delete_selected"]'
            );
            o.forEach((e) => {
                e.addEventListener("click", function () {
                    console.log(e),
                        setTimeout(function () {
                            s();
                        }, 50);
                });
            }),
                n.addEventListener("click", function () {
                    Swal.fire({
                        text: "Are you sure you want to delete selected files or folders?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton:
                                "btn fw-bold btn-active-light-primary",
                        },
                    }).then(function (n) {
                        n.value
                            ? Swal.fire({
                                  text: "You have deleted all selected  files or folders!.",
                                  icon: "success",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              }).then(function () {
                                  o.forEach((t) => {
                                      t.checked &&
                                          e
                                              .row($(t.closest("tbody tr")))
                                              .remove()
                                              .draw();
                                  });
                                  t.querySelectorAll(
                                      '[type="checkbox"]'
                                  )[0].checked = !1;
                              })
                            : "cancel" === n.dismiss &&
                              Swal.fire({
                                  text: "Selected  files or folders was not deleted.",
                                  icon: "error",
                                  buttonsStyling: !1,
                                  confirmButtonText: "Ok, got it!",
                                  customClass: {
                                      confirmButton: "btn fw-bold btn-primary",
                                  },
                              });
                    });
                });
        },
        s = () => {
            const e = document.querySelector(
                    '[data-kt-filemanager-table-toolbar="base"]'
                ),
                o = document.querySelector(
                    '[data-kt-filemanager-table-toolbar="selected"]'
                ),
                n = document.querySelector(
                    '[data-kt-filemanager-table-select="selected_count"]'
                ),
                r = t.querySelectorAll('tbody [type="checkbox"]');
            let a = !1,
                l = 0;
            r.forEach((e) => {
                e.checked && ((a = !0), l++);
            }),
                a
                    ? ((n.innerHTML = l),
                      e.classList.add("d-none"),
                      o.classList.remove("d-none"))
                    : (e.classList.remove("d-none"), o.classList.add("d-none"));
        },
        c = () => {
            const e = t.querySelector("#kt_file_manager_new_folder_row");
            e && e.parentNode.removeChild(e);
        },
        d = () => {
            t.querySelectorAll('[data-kt-filemanager-table="rename"]').forEach(
                (e) => {
                    e.addEventListener("click", u);
                }
            );
        },
        u = (o) => {
            let r;
            if (
                (o.preventDefault(),
                t.querySelectorAll("#kt_file_manager_rename_input").length > 0)
            )
                return void Swal.fire({
                    text: "Unsaved input detected. Please save or cancel the current item",
                    icon: "warning",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: { confirmButton: "btn fw-bold btn-danger" },
                });
            const a = o.target.closest("tr"),
                l = a.querySelectorAll("td")[1],
                i = l.querySelector(".svg-icon");
            let directory_id = l
                .querySelector(".directory-item")
                .getAttribute("data-id");
            r = l.innerText;
            const s = n.cloneNode(!0);
            (s.querySelector("#kt_file_manager_rename_folder_icon").innerHTML =
                i.outerHTML),
                (l.innerHTML = s.innerHTML),
                (a.querySelector("#kt_file_manager_rename_input").value = r);
            var c = FormValidation.formValidation(l, {
                fields: {
                    rename_folder_name: {
                        validators: {
                            notEmpty: { message: "Name is required" },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: "",
                    }),
                },
            });
            document
                .querySelector("#kt_file_manager_rename_folder")
                .addEventListener("click", (t) => {
                    t.preventDefault(),
                        c &&
                            c.validate().then(function (t) {
                                console.log("validated!"),
                                    "Valid" == t &&
                                        Swal.fire({
                                            text:
                                                "Are you sure you want to rename " +
                                                r +
                                                "?",
                                            icon: "warning",
                                            showCancelButton: !0,
                                            buttonsStyling: !1,
                                            confirmButtonText:
                                                "Yes, rename it!",
                                            cancelButtonText: "No, cancel",
                                            customClass: {
                                                confirmButton:
                                                    "btn fw-bold btn-danger",
                                                cancelButton:
                                                    "btn fw-bold btn-active-light-primary",
                                            },
                                        }).then(function (t) {
                                            t.value
                                                ? $.ajax({
                                                      url: `/${siteUserRole}/directory/${directory_id}`,
                                                      type: "PUT",
                                                      // add crsf token
                                                      headers: {
                                                          "X-CSRF-TOKEN": $(
                                                              'meta[name="csrf-token"]'
                                                          ).attr("content"),
                                                          // PUT
                                                          _method: "PUT",
                                                      },
                                                      data: {
                                                          name: document.querySelector(
                                                              "#kt_file_manager_rename_input"
                                                          ).value,
                                                      },
                                                      success: function (res) {
                                                          Swal.fire({
                                                              text:
                                                                  "You have renamed " +
                                                                  r +
                                                                  "!.",
                                                              icon: "success",
                                                              buttonsStyling:
                                                                  !1,
                                                              confirmButtonText:
                                                                  "Ok, got it!",
                                                              customClass: {
                                                                  confirmButton:
                                                                      "btn fw-bold btn-primary",
                                                              },
                                                          }).then(function () {
                                                              KTFileManagerList.loadDirectoryContents(
                                                                  DIRECTORY_MAP[
                                                                      DIRECTORY_MAP.length -
                                                                          1
                                                                  ].id
                                                              );
                                                          });
                                                      },
                                                      error: function (t) {
                                                          Swal.fire({
                                                              text:
                                                                  "Error: " + t,
                                                              icon: "error",
                                                              buttonsStyling:
                                                                  !1,
                                                              confirmButtonText:
                                                                  "Ok, got it!",
                                                              customClass: {
                                                                  confirmButton:
                                                                      "btn btn-primary",
                                                              },
                                                          });
                                                      },
                                                  })
                                                : "cancel" === t.dismiss &&
                                                  Swal.fire({
                                                      text:
                                                          r +
                                                          " was not renamed.",
                                                      icon: "error",
                                                      buttonsStyling: !1,
                                                      confirmButtonText:
                                                          "Ok, got it!",
                                                      customClass: {
                                                          confirmButton:
                                                              "btn fw-bold btn-primary",
                                                      },
                                                  });
                                        });
                            });
                });
            const d = document.querySelector(
                "#kt_file_manager_rename_folder_cancel"
            );
            d.addEventListener("click", (t) => {
                t.preventDefault(),
                    d.setAttribute("data-kt-indicator", "on"),
                    setTimeout(function () {
                        const t = `<div class="d-flex align-items-center">${i.outerHTML}<a href="?page=apps/file-manager/files/" class="text-gray-800 text-hover-primary">${r}</a></div>`;
                        d.removeAttribute("data-kt-indicator"),
                            e.cell($(l)).data(t).draw(),
                            (toastr.options = {
                                closeButton: !0,
                                debug: !1,
                                newestOnTop: !1,
                                progressBar: !1,
                                positionClass: "toastr-top-right",
                                preventDuplicates: !1,
                                showDuration: "300",
                                hideDuration: "1000",
                                timeOut: "5000",
                                extendedTimeOut: "1000",
                                showEasing: "swing",
                                hideEasing: "linear",
                                showMethod: "fadeIn",
                                hideMethod: "fadeOut",
                            }),
                            toastr.error("Cancelled rename function");
                    }, 1e3);
            });
        },
        m = () => {
            t.querySelectorAll(
                '[data-kt-filemanger-table="copy_link"]'
            ).forEach((e) => {
                const t = e.querySelector("button"),
                    o = e.querySelector(
                        '[data-kt-filemanger-table="copy_link_generator"]'
                    ),
                    n = e.querySelector(
                        '[data-kt-filemanger-table="copy_link_result"]'
                    ),
                    r = e.querySelector("input");
                t.addEventListener("click", (e) => {
                    var t;
                    e.preventDefault(),
                        o.classList.remove("d-none"),
                        n.classList.add("d-none"),
                        clearTimeout(t),
                        (t = setTimeout(() => {
                            o.classList.add("d-none"),
                                n.classList.remove("d-none"),
                                r.select();
                        }, 2e3));
                });
            });
        },
        f = () => {
            document.getElementById("kt_file_manager_items_counter").innerText =
                e.rows().count() + " items";
        };
    return {
        init: function () {
            (t = document.querySelector("#kt_file_manager_list")) &&
                ((o = document.querySelector(
                    '[data-kt-filemanager-template="upload"]'
                )),
                (n = document.querySelector(
                    '[data-kt-filemanager-template="rename"]'
                )),
                (r = document.querySelector(
                    '[data-kt-filemanager-template="action"]'
                )),
                (a = document.querySelector(
                    '[data-kt-filemanager-template="checkbox"]'
                )),
                (() => {
                    t.querySelectorAll("tbody tr").forEach((e) => {
                        const t = e.querySelectorAll("td")[3],
                            o = moment(t.innerHTML, "DD MMM YYYY, LT").format();
                        t.setAttribute("data-order", o);
                    });
                    const o = {
                            info: !1,
                            order: [],
                            scrollY: "700px",
                            scrollCollapse: !0,
                            paging: !1,
                            ordering: !1,
                            columns: [
                                { data: "checkbox" },
                                { data: "name" },
                                { data: "size" },
                                { data: "date" },
                                { data: "action" },
                            ],
                            language: {
                                emptyTable: `<div class="d-flex flex-column flex-center"><img src="/media/illustrations/sketchy-1/5.png" class="mw-400px" /><div class="fs-1 fw-bolder text-dark">No items found.</div><div class="fs-6">Start creating new folders or uploading a new file!</div></div>`,
                            },
                        },
                        n = {
                            info: !1,
                            order: [],
                            pageLength: 10,
                            lengthChange: !1,
                            ordering: !1,
                            columns: [
                                { data: "checkbox" },
                                { data: "name" },
                                { data: "size" },
                                { data: "date" },
                                { data: "action" },
                            ],
                            language: {
                                emptyTable: `<div class="d-flex flex-column flex-center"><img src="/media/illustrations/sketchy-1/5.png" class="mw-400px" /><div class="fs-1 fw-bolder text-dark mb-4">No items found.</div><div class="fs-6">Start creating new folders or uploading a new file!</div></div>`,
                            },
                            conditionalPaging: !0,
                        };
                    var r;
                    (r =
                        "folders" ===
                        t.getAttribute("data-kt-filemanager-table")
                            ? o
                            : n),
                        (e = $(t).DataTable(r)).on("draw", function () {
                            i(),
                                l(),
                                s(),
                                c(),
                                KTMenu.createInstances(),
                                m(),
                                f(),
                                d();
                        });
                })(),
                i(),
                document
                    .querySelector(
                        '[data-kt-filemanager-table-filter="search"]'
                    )
                    .addEventListener("keyup", function (t) {
                        e.search(t.target.value).draw();
                    }),
                l(),
                document
                    .getElementById("kt_file_manager_new_folder")
                    .addEventListener("click", (n) => {
                        if (
                            (n.preventDefault(),
                            t.querySelector("#kt_file_manager_new_folder_row"))
                        )
                            return;
                        const l = t.querySelector("tbody"),
                            i = o.cloneNode(!0);
                        l.prepend(i);
                        const s = i.querySelector(
                                "#kt_file_manager_add_folder_form"
                            ),
                            d = i.querySelector("#kt_file_manager_add_folder"),
                            u = i.querySelector(
                                "#kt_file_manager_cancel_folder"
                            ),
                            m = i.querySelector(".svg-icon-2x"),
                            f = i.querySelector('[name="new_folder_name"]');
                        var g = FormValidation.formValidation(s, {
                            fields: {
                                new_folder_name: {
                                    validators: {
                                        notEmpty: {
                                            message: "Folder name is required",
                                        },
                                    },
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap:
                                    new FormValidation.plugins.Bootstrap5({
                                        rowSelector: ".fv-row",
                                        eleInvalidClass: "",
                                        eleValidClass: "",
                                    }),
                            },
                        });
                        d.addEventListener("click", (t) => {
                            t.preventDefault(),
                                d.setAttribute("data-kt-indicator", "on"),
                                g &&
                                    g.validate().then(function (t) {
                                        console.log("validated!"),
                                            "Valid" == t
                                                ? // Ajax to create new folder
                                                  $.ajax({
                                                      url: `/${siteUserRole}/directory`,
                                                      type: "POST",
                                                      // add crsf token
                                                      headers: {
                                                          "X-CSRF-TOKEN": $(
                                                              'meta[name="csrf-token"]'
                                                          ).attr("content"),
                                                      },
                                                      data: {
                                                          name: f.value,
                                                          parent_id:
                                                              DIRECTORY_MAP[
                                                                  DIRECTORY_MAP.length -
                                                                      1
                                                              ].id,
                                                      },
                                                      success: function (res) {
                                                          Swal.fire({
                                                              text: `Folder - ${res.directory.name} was created successfully!`,
                                                              icon: "success",
                                                              buttonsStyling:
                                                                  !1,
                                                              confirmButtonText:
                                                                  "Ok, got it!",
                                                              customClass: {
                                                                  confirmButton:
                                                                      "btn fw-bold btn-primary",
                                                              },
                                                          }).then(function () {
                                                              KTFileManagerList.loadDirectoryContents(
                                                                  DIRECTORY_MAP[
                                                                      DIRECTORY_MAP.length -
                                                                          1
                                                                  ].id
                                                              );
                                                          });
                                                      },
                                                      error: function (t) {
                                                          d.removeAttribute(
                                                              "data-kt-indicator"
                                                          ),
                                                              Swal.fire({
                                                                  text:
                                                                      "Error: " +
                                                                      t,
                                                                  icon: "error",
                                                                  buttonsStyling:
                                                                      !1,
                                                                  confirmButtonText:
                                                                      "Ok, got it!",
                                                                  customClass: {
                                                                      confirmButton:
                                                                          "btn btn-primary",
                                                                  },
                                                              });
                                                      },
                                                  })
                                                : // End of Ajax
                                                  d.removeAttribute(
                                                      "data-kt-indicator"
                                                  );
                                    });
                        }),
                            u.addEventListener("click", (e) => {
                                e.preventDefault(),
                                    u.setAttribute("data-kt-indicator", "on"),
                                    setTimeout(function () {
                                        u.removeAttribute("data-kt-indicator"),
                                            (toastr.options = {
                                                closeButton: !0,
                                                debug: !1,
                                                newestOnTop: !1,
                                                progressBar: !1,
                                                positionClass:
                                                    "toastr-top-right",
                                                preventDuplicates: !1,
                                                showDuration: "300",
                                                hideDuration: "1000",
                                                timeOut: "5000",
                                                extendedTimeOut: "1000",
                                                showEasing: "swing",
                                                hideEasing: "linear",
                                                showMethod: "fadeIn",
                                                hideMethod: "fadeOut",
                                            }),
                                            toastr.error(
                                                "Cancelled new folder creation"
                                            ),
                                            c();
                                    }, 1e3);
                            });
                    }),
                m(),
                d(),
                f(),
                KTMenu.createInstances());
        },
        loadDirectoryContents: function (directoryId) {
            $.ajax({
                url: `/${siteUserRole}/directory`,
                type: "GET",
                data: {
                    directory_id: directoryId,
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (res) {
                    const t = e.rows().count();
                    for (let o = 0; o < t; o++) e.row(0).remove();
                    res.directories.forEach((t) => {
                        let last_updated = moment(t.updated_at).format(
                            "DD MMM YYYY, LT"
                        );
                        const o = document.createElement("a");
                        o.setAttribute("data-id", t.id),
                            o.setAttribute("href", "#"),
                            o.classList.add(
                                "directory-item",
                                "text-gray-800",
                                "text-hover-primary"
                            ),
                            (o.innerText = t.name);
                        let template = document.querySelector(
                            '[data-kt-filemanager-template="upload"]'
                        );
                        let m = template.querySelector(".svg-icon-2x");
                        const n = e.row
                            .add({
                                checkbox: a.innerHTML,
                                name: m.outerHTML + o.outerHTML,
                                size: "-",
                                date: last_updated,
                                action: r.innerHTML,
                            })
                            .node();
                        $(n)
                            .find("td")
                            .eq(4)
                            .attr(
                                "data-kt-filemanager-table",
                                "action_dropdown"
                            ),
                            $(n).find("td").eq(4).addClass("text-end");

                        $(n).find(".download-action-button").hide();
                    });
                    res.files.forEach((t) => {
                        let last_updated = moment(t.updated_at).format(
                            "DD MMM YYYY, LT"
                        );
                        const o = document.createElement("a");
                        o.setAttribute("data-id", t.id),
                            o.setAttribute("href", "#"),
                            o.classList.add(
                                "directory-file",
                                "text-gray-800",
                                "text-hover-primary"
                            ),
                            (o.innerText = t.name);
                        let m = t.mime_type.includes("image")
                            ? `
                        <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z" fill="currentColor"></path>
                                <path d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        `
                            : `
                        <span class="svg-icon svg-icon-2x svg-icon-primary me-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="currentColor"></path>
                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        `;
                        const n = e.row
                            .add({
                                checkbox: a.innerHTML,
                                name: m + o.outerHTML,
                                size: t.size,
                                date: last_updated,
                                action: r.innerHTML,
                            })
                            .node();
                        $(n)
                            .find("td")
                            .eq(4)
                            .attr(
                                "data-kt-filemanager-table",
                                "action_dropdown"
                            ),
                            $(n).find("td").eq(4).addClass("text-end");

                        // hide rename
                        $(n).find(".rename-action-button").hide();
                        $(n)
                            .find(".download-action-button")
                            .attr("href", `${t.url}?download=true`);
                    });
                    f();
                    // redraw the table
                    e.draw();
                    KTFileManagerList.initFileTraversal();

                    const newRefId = DIRECTORY_MAP[DIRECTORY_MAP.length - 1].id;

                    // clear dropzone completely
                    if (dropzoneInstance) {
                        // clear queue
                        dropzoneInstance.removeAllFiles(true);
                        dropzoneInstance.destroy();
                    }
                    // initialize dropzone
                    KTFileManagerList.initializeDropzone(newRefId);
                },
                error: function (e) {
                    Swal.fire({
                        text: "Error: " + e,
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: { confirmButton: "btn btn-primary" },
                    });
                },
            });
        },
        initFileTraversal: function () {
            document.querySelectorAll(".directory-item").forEach((e) => {
                e.addEventListener("click", function (t) {
                    t.preventDefault();
                    const o = e.getAttribute("data-id");
                    DIRECTORY_MAP.push({
                        id: o,
                        name: e.innerText,
                        parent: DIRECTORY_MAP[DIRECTORY_MAP.length - 1].id,
                    });
                    updateDirectoryMap();
                    KTFileManagerList.loadDirectoryContents(o);
                });
            });
        },
        initializeDropzone: function (ref_id) {
            const e = "#kt_modal_upload_dropzone",
                t = document.querySelector(e);
            t.querySelector(".dropzone-items").innerHTML = "";
            var o = document.getElementById("dropzone_template").cloneNode(!0);
            o.id = "";
            var n = document.getElementById("dropzone_template").innerHTML;
            dropzoneInstance = new Dropzone(e, {
                url: `/${siteUserRole}/attachment`,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                params: {
                    ref_id: ref_id,
                },
                parallelUploads: 10,
                previewTemplate: n,
                maxFilesize: 1,
                autoProcessQueue: !1,
                autoQueue: 1,
                previewsContainer: e + " .dropzone-items",
                clickable: e + " .dropzone-select",
            });
            dropzoneInstance.on("addedfile", function (o) {
                (o.previewElement.querySelector(
                    e + " .dropzone-start"
                ).onclick = function () {
                    // upload the file show progress
                    dropzoneInstance.processFile(o);
                }),
                    t.querySelectorAll(".dropzone-item").forEach((e) => {
                        e.style.display = "";
                    }),
                    (t.querySelector(".dropzone-upload").style.display =
                        "inline-block"),
                    (t.querySelector(".dropzone-remove-all").style.display =
                        "inline-block");
            }),
                dropzoneInstance.on("complete", function (e) {
                    const o = t.querySelectorAll(".dz-complete");
                    setTimeout(function () {
                        o.forEach((e) => {
                            (e.querySelector(".progress-bar").style.opacity =
                                "0"),
                                (e.querySelector(".progress").style.opacity =
                                    "0"),
                                (e.querySelector(
                                    ".dropzone-start"
                                ).style.opacity = "0");
                        });
                    }, 300);
                    // remove the current file from dropzone
                    dropzoneInstance.removeFile(e);
                    // update the table
                    KTFileManagerList.loadDirectoryContents(
                        DIRECTORY_MAP[DIRECTORY_MAP.length - 1].id
                    );
                }),
                dropzoneInstance.on("queuecomplete", function (e) {
                    t.querySelectorAll(".dropzone-upload").forEach((e) => {
                        e.style.display = "none";
                    });
                }),
                dropzoneInstance.on("removedfile", function (e) {
                    dropzoneInstance.files.length < 1 &&
                        ((t.querySelector(".dropzone-upload").style.display =
                            "none"),
                        (t.querySelector(".dropzone-remove-all").style.display =
                            "none"));
                });
            if (!DROPZONE_EVENTS_ADDED) {
                t.querySelector(".dropzone-upload").addEventListener(
                    "click",
                    function () {
                        dropzoneInstance.files.forEach((e) => {
                            dropzoneInstance.processFile(e);
                        });
                    }
                );
                t.querySelector(".dropzone-remove-all").addEventListener(
                    "click",
                    function () {
                        Swal.fire({
                            text: "Are you sure you would like to remove all files?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, remove it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light",
                            },
                        }).then(function (e) {
                            e.value
                                ? ((t.querySelector(
                                      ".dropzone-upload"
                                  ).style.display = "none"),
                                  (t.querySelector(
                                      ".dropzone-remove-all"
                                  ).style.display = "none"),
                                  dropzoneInstance.removeAllFiles(!0))
                                : "cancel" === e.dismiss &&
                                  Swal.fire({
                                      text: "Your files was not removed!.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "Ok, got it!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                        });
                    }
                );
                DROPZONE_EVENTS_ADDED = true;
            }
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTFileManagerList.init();
    KTFileManagerList.loadDirectoryContents(null);
});
