@extends('vendor.layouts.default') <!-- Adjust the layout path according to your project -->
@section('pageTitle', 'Add Customer Invoice')
@section('content')
<style>
    .search-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 20px auto;
    }
    .search-box {
        width: 100%;
        padding: 10px 15px;
    }
    .item-parent-div {
        position: relative;
        max-width: 500px;
    }

    .item-parent-div .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%; /* Aligns just below the input field */
        left: 0; /* Aligns with the input field */
        width: 100%;
        max-width: 480px;
        max-height: 250px;
        overflow-y: auto;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
        z-index: 1050;
    }

    .item-parent-div .dropdown-item {
        padding: 10px;
        display: flex;
        align-items: center;
    }
    .item-parent-div .dropdown-item i {
        margin-right: 10px;
    }
    .item-parent-div .dropdown-item:hover {
        background-color: #d7d7d7;
    }
    .highlight {
        font-weight: bold;
    }
    .item-parent-div {
        max-width: 500px;
    }
    li.select-item {
        padding: 2px 5px;
        font-size: 16px;
        cursor: pointer;
    }
    input.qty {
        margin-left: 3px;
        margin-right: 3px;
        border-radius: 5px !important;
    }
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Add New Customer Invoice</h1>
        <!-- Back Button -->
        <a href="{{ route('vendor.invoice.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Customer Invoice 
                <!-- <span id="invoice-number" data-invoice="00000001" class="d-none" style="float: right;"> Invoice No: #00000001 </span> -->
            </h6>
        </div>
        <div class="card-body">
            <form id="ticketForm" action="{{ route('vendor.invoice.store') }}" method="POST" class="row" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Customer Name" />
                    <input type="hidden" id="hidden-invoice-number" name="invoice-number" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="mobile" name="mobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Customer Mobile Number" />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Customer Email" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="message" class="form-label">Message </label>
                    <input type="text" class="form-control" id="message" name="message" placeholder="Enter Message" />
                </div>

                <div class="row clearfix w-100">
                    <div class="col-md-12 text-right">
                      <button type="button" class="btn btn-primary px-4 me-2 my-1 m-2 add-item add-to-last"><i class="fas fa-plus"></i> Add Item</button>
                      <!-- <button id='delete_row' type="button" class="pull-right btn btn-default">Delete Row</button> -->
                    </div>
                </div>
                <div class="row clearfix w-100">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover" id="tab_logic">
                        <thead>
                          <tr>
                            <th class="text-center" width="50"> # </th>
                            <th class="text-center"> Item </th>
                            <th class="text-center" width="160"> Quantity </th>
                            <th class="text-center" width="100"> Type </th>
                            <th class="text-center" width="150"> Price </th>
                            <th class="text-center" width="150"> Total </th>
                            <th class="text-center" width="100"> Action </th>
                          </tr>
                        </thead>
                        <tbody class="item-body">
                          <!-- <tr class="item-row">
                            <td class="text-center item-sr-number">1</td>
                            <td>
                                <div class="item-parent-div">
                                    <input type="text" name="item[]" placeholder="Enter Item Name" class="form-control search-box"/>
                                    <ul class="dropdown-menu"></ul>
                                </div>
                                <input type="hidden" name="item_id[]" class="item-id" value="0" />
                                <input type="hidden" class="half-price" value="0" />
                                <input type="hidden" class="full-price" value="0" />
                            </td>
                            <td>
                                <div class="input-group">
                                    <button type="button" class="btn btn-sm btn-danger me-2 minus"><i class="fas fa-minus"></i></button>
                                    <input type="text" name="qty[]" inputmode="decimal" placeholder="Enter Qty" class="form-control qty text-center" value="0" min="0" step="0.01">
                                    <button type="button" class="btn btn-sm btn-primary me-2 plus"><i class="fas fa-plus"></i></button>
                                </div>
                            </td>
                            <td>
                                <select name="type[]" class="form-control price-type">
                                    <option value="1">Half</option>
                                    <option value="2">Full</option>
                                </select>
                            </td>
                            <td><input type="text" name="price[]" inputmode="decimal" placeholder="Enter Price" class="form-control price decimal-number" step="0.00" min="0"/></td>
                            <td><input type="text" name="total[]" placeholder="0.00" class="form-control total" readonly/></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary me-2 my-1 m-1 add-item add-to-next"><i class="fas fa-plus"></i></button>
                                <button type="button" class="btn btn-sm btn-danger me-2 my-1 delete-item"><i class="fas fa-trash"></i></button>
                            </td>
                          </tr> -->
                        </tbody>
                      </table>
                    </div>
                </div>
                <div class="row clearfix w-100" style="margin-top:20px">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                      <table class="table table-bordered table-hover" id="tab_logic_total">
                        <tbody>
                          <tr>
                            <th class="text-right">Sub Total</th>
                            <td class="text-right"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                          </tr>
                          <tr>
                            <th class="text-right">Discount</th>
                            <td class="text-right">
                                <div class="input-group mb-2 mb-sm-0">
                                    <input type="text" class="form-control decimal-number" id="discount" name='discount' placeholder="0">
                                    <div class="input-group-addon p-2">%</div>
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <th class="text-right">Tax</th>
                            <td class="text-right">
                                <div class="input-group mb-2 mb-sm-0">
                                    <input type="text" class="form-control decimal-number" id="tax" name="tax" placeholder="0">
                                    <div class="input-group-addon p-2">%</div>
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <th class="text-right">Grand Total</th>
                            <td class="text-right"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <!-- <button type="submit" class="btn btn-primary m-1"><i class="bi bi-floppy"></i> Submit</button> -->
                    <button type="submit" class="btn btn-primary m-1"><i class="bi bi-floppy"></i> Submit & Print</button>
                </div>
            </form>  
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#ticketForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var isValid = true;

            // Simple Validation
            if ($(this).find('#name').val() == '') {
                toastr.error("Please enter the name.");
                isValid = false;
            }
            if ($(this).find('#mobile').val() == '') {
                toastr.error("Please enter the mobile.");
                isValid = false;
            }

            if (isValid) {
                // Ajax form submission
                let formData = new FormData(this); // Use FormData to handle files
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 1) {
                            toastr.success(response.message);
                            $("#ticketform").trigger("reset");
                            setTimeout(function () {
                                window.open(response.print_url, '_blank');
                                // window.location.reload();
                                // window.location.href = response.print_url;
                                window.location.href = "{{ route('vendor.invoice.index') }}";
                            }, 300);
                        } else {
                            // Properly handle array or string responses
                            if (Array.isArray(response.message)) {
                                response.message.forEach(function(error) {
                                    toastr.error(error);
                                });
                            } else if (typeof response.message === 'string') {
                                toastr.error(response.message);
                            } else {
                                toastr.error('An unknown error occurred.');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + error);
                    }
                });
            }
        });

        $(document).on("click", ".add-item", function () {
            let html = '', pattern = '^\d*\.?\d*$';
            html += '<tr class="item-row">';
                html += '<td class="text-center item-sr-number">1</td>';
                html += '<td>\
                            <div class="item-parent-div">\
                                <input type="text" name="item[]" placeholder="Enter Item Name" class="form-control search-box"/>\
                                <ul class="dropdown-menu"></ul>\
                            </div>\
                            <input type="hidden" name="item_id[]" class="item-id" value="0" />\
                            <input type="hidden" class="half-price" value="0" />\
                            <input type="hidden" class="full-price" value="0" />\
                        </td>';
                html += '<td>\
                            <div class="input-group">\
                                <button type="button" class="btn btn-sm btn-danger me-2 minus"><i class="fas fa-minus"></i></button>\
                                <input type="text" name="qty[]" inputmode="decimal" placeholder="Enter Qty" class="form-control qty text-center" value="0" min="0" step="0.01">\
                                <button type="button" class="btn btn-sm btn-primary me-2 plus"><i class="fas fa-plus"></i></button>\
                            </div>\
                        </td>';
                html += '<td>';
                    html += '<select name="type[]" class="form-control price-type">';
                        html += '<option value="1">Half</option>';
                        html += '<option value="2">Full</option>';
                    html += '</select>';
                html += '</td>';
                html += '<td><input type="text" name="price[]" inputmode="decimal" placeholder="Enter Price" class="form-control price decimal-number" step="0.00" min="0"/></td>';
                html += '<td><input type="text" name="total[]" placeholder="0.00" class="form-control total" readonly/></td>';
                html += '<td>';
                    html += '<button type="button" class="btn btn-sm btn-primary m-1 me-2 my-1 add-item add-to-next"><i class="fas fa-plus"></i></button>';
                    html += '<button type="button" class="btn btn-sm btn-danger me-2 my-1 delete-item"><i class="fas fa-trash"></i></button>';
                html += '</td>';
            html += '</tr>';

            if($(this).hasClass("add-to-next")){
                $(this).closest(".item-row").after(html);
            }else{
                $('.item-body').append(html);
            }

            calc();
        });

        $(".add-item").click();

        $(".decimal-number").on("input", function () {
            $(this).val($(this).val()
                .replace(/[^0-9.]/g, '') // Remove non-numeric characters except "."
                .replace(/^(\d*\.?\d{0,2}).*$/, '$1') // Allow only two digits after decimal
                .replace(/(\..*)\./g, '$1') // Ensure only one decimal point
            );
        });

        $(document).on("click", ".delete-item", function () {
            $(this).parents(".item-row").remove();
            calc();
        });
        
        $('#tab_logic tbody').on('keyup change',function(){
            calc();
        });
    });

    function calc()
    {
        updateSerialNumbers();

        $('.item-row').each(function(i, element) {
            var html = $(this).html();
            if(html!='')
            {
                var qty = $(this).find('.qty').val();
                var price = $(this).find('.price').val();
                $(this).find('.total').val(qty*price);
                
                calculateGrandTotal();
            }
        });
    }
    function calculateGrandTotal() {
        let subTotal = 0;
        $('.total').each(function() {
            subTotal += parseFloat($(this).val());
        });
        $('#sub_total').val(subTotal.toFixed(2));

        subTotal = parseFloat($("#sub_total").val()) || 0;
        let gst = parseFloat($("#tax").val()) || 0;
        let discount = parseFloat($("#discount").val()) || 0;

        // Calculate Discount Amount
        let discountAmount = 0;
        if(discount){
            discountAmount = (subTotal * discount) / 100;
        }

        // Calculate Grand Total
        let grandDiscountTotal = subTotal - discountAmount;

        // Calculate GST Amount
        let gstAmount = 0;
        if(gst){
            gstAmount = (grandDiscountTotal * gst) / 100;
        }
        let grandTotal = grandDiscountTotal + gstAmount;

        // Update Grand Total in the input field
        $("#total_amount").val(grandTotal.toFixed(2));
    }

    // Trigger Calculation on GST, Discount, and Sub Total change
    $("#tax, #discount").on("input", function () {
        calculateGrandTotal();
    });
    function updateSerialNumbers() {
        let sr_no = 1;
        $('.item-row').each(function () {
            $(this).find(".item-sr-number").html(sr_no);
            sr_no++;
        });
    }
    
    $(document).ready(function() {
        $(document).on("input", ".search-box", function(){
            let value = $(this).val().toLowerCase();
            let dropdown = $(this).parents('.item-parent-div').find('.dropdown-menu');
            dropdown.empty();

            // let search_word = $(this).val();

            $.ajax({
                url: "{{ route('vendor.invoice.search-vendor-item') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    item_search: value
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        // toastr.success(response.message);
                        let items = response.items;
                        if (items.length > 0) {
                            items.forEach(item => {
                                var regex = new RegExp(value, 'gi');
                                var highlightedText = item.name.replace(regex, match => `<span class='highlight'>${match}</span>`);
                                dropdown.append(`<li value="${item.id}" data-item-name="${item.name}" data-half-price="${item.price_half}" data-full-price="${item.price_full}" class="select-item">${highlightedText}</li>`);
                            });
                            dropdown.show();
                        } else {
                            dropdown.hide();
                        }
                    } else {
                        if (typeof response.message === 'string') {
                            toastr.error(response.message);
                        } else {
                            toastr.error('An unknown error occurred.');
                        }
                        dropdown.append(`<li value="" class="select-no-item">No item found</li>`);
                        dropdown.show();
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                }
            });
        });
        $(document).on("click", ".select-item", function(){
            let item_id = $(this).attr('value');
            let item_name = $(this).data('item-name');
            let item_half_price = $(this).data('half-price');
            let item_full_price = $(this).data('full-price');

            let row_td = $(this).parents("tr.item-row");
            row_td.find(".search-box").val(item_name);
            row_td.find(".item-id").val(item_id);

            let price_type = row_td.find(".price-type").val();
            if(price_type == 1){
                row_td.find(".price").val(item_half_price);
            }else{
                row_td.find(".price").val(item_full_price);
            }
            row_td.find(".half-price").val(item_half_price);
            row_td.find(".full-price").val(item_full_price);

            calc();
        });
        $(document).on("click", ".price-type", function(){
            let row_td = $(this).parents("tr.item-row");
            let item_half_price = row_td.find(".half-price").val();
            let item_full_price = row_td.find(".full-price").val();
            let price_type = row_td.find(".price-type").val();

            if(price_type == 1){
                row_td.find(".price").val(item_half_price);
            }else{
                row_td.find(".price").val(item_full_price);
            }

            calc();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('.search-container').length) {
                $('.dropdown-menu').hide();
            }
        });

        $(document).on("click", ".plus", function(){
            let input = $(this).siblings('.qty');
            let currentValue = parseFloat(input.val()) || 0;
            input.val((currentValue + 1).toFixed(2)); // Increase by 1, keep 2 decimal places

            calc();
        });

        $(document).on("click", ".minus", function(){
            let input = $(this).siblings('.qty');
            let currentValue = parseFloat(input.val()) || 0;
            if (currentValue > 0) {
                input.val((currentValue - 1).toFixed(2)); // Decrease by 1, but not below 0
            }
            calc();
        });
    });
</script>
@endsection
