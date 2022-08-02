var DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $(".manage-products").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/coupons"}},
                pageSize: 10,
                saveState: {cookie: !0, webstorage: !0},
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !0,
            },
            layout: {theme: "default", class: "", scroll: !1, footer: !1},
            sortable: false,
            ordering: false,
            filterable: !1,
            pagination: !0,
            columns:
                [
                    {field: "id", title: "#",  width: 100 },
                    {field: "name", title: "Coupon Title",  width: 150},
                    {field: "coupon_code", title: "Coupon Code",  width: 150},
                    {field: "discount", title: "Discount",  width: 100},
                    {field: "coupon_type", title: "Type",  width: 150},
                    {field: "coupon_number", title: "Number",  width: 150},
                    {field: "status", title: "Status",  width: 70},
                    {field: "end_date", title: "Expiry Date",  width: 150},
                    {field: "actions", title: "Action",  width: 150}
                ]
        });
        t.on('m-datatable--on-layout-updated', function(params){
            $('.delete-record-button').on('click', function(e){
                var url = $(this).data('url');
                swal({
                        title: "Are you sure you want to delete this?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "No",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'delete',
                                url: url,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                                }
                            }).done(function(res){ toastr.success("Coupon deleted successfully!"); location.reload(); })
                                .fail(function(res){ toastr.success("Coupon Failed!"); t.reload();  });
                        } else {
                            swal.close()
                        }
                    });
            });

            $('.m-datatable__table tbody').on('click', 'tr', function(e) {
                var elem = $(this).children(':nth-child(8)').find('a');
                if (elem.length==1) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = $(elem[0]).attr('href');
                    return false;
                }
            })

        });


    };
    return {
        init: function () {
            t()
        }
    }
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()

});
