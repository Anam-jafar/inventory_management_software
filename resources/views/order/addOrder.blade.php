@extends('layouts.template')
@section('content')
@if ($errors->any())
    @foreach ($errors->all() as $error)
        @php
            notify()->error($error, 'Failed');
        @endphp
    @endforeach
@endif

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create Order</h4>
                <p class="card-description"> Enter necessary information in the form below to create a new order. </p>
                <form class="forms-sample" method="POST" enctype="multipart/form-data" id="createOrderForm">
                    @csrf
                    <div id="order-items">
                        <div class="form-group row order-item">
                            <label for="product" class="col-sm-3 col-form-label">Product</label>
                            <div class="col-sm-6">
                                <select class="form-control product-select" id="product" name="products[]">
                                    <option value="">Choose product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="quantity" class="col-sm-1 col-form-label">Quantity</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control quantity-input" id="quantity" name="quantities[]" placeholder="Quantity">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-secondary btn-sm" id="addMoreItems">Add More Items</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="customer" class="col-sm-3 col-form-label">Choose Customer</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="customer" name="customer_id">
                                <option value="">Choose customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-info" id="addNewCustomer">Add New Customer</button>
                        </div>
                    </div>
                    <div id="newCustomerFields" style="display:none;">
                        <div class="form-group row">
                            <label for="customerName" class="col-sm-3 col-form-label">Customer Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="customerName" placeholder="Enter customer name" name="new_customer_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customerContact" class="col-sm-3 col-form-label">Customer Contact</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="customerContact" placeholder="Enter customer contact" name="new_customer_contact">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Amount</label>
                        <div class="col-sm-9">
                            <p id="totalAmount" class="form-control-static">$0.00</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Discount</label>
                        <div class="col-sm-2">
                            <label class="switch">
                                <input type="checkbox" id="discountSwitch">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div id="discountFields" style="display:none;">
                        <div class="form-group row">
                            <label for="discountType" class="col-sm-3 col-form-label">Discount Type</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="discountType" name="discount_type">
                                    <option value="percentage">Percentage</option>
                                    <option value="amount">Amount</option>
                                </select>
                            </div>
                            <label for="discountValue" class="col-sm-3 col-form-label">Discount Value</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="discountValue" name="discount_value" placeholder="Discount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Discounted Total</label>
                            <div class="col-sm-9">
                                <p id="discountedTotal" class="form-control-static">$0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-rounded btn-success btn-lg"><i class="mdi mdi-content-save"></i> Save</button>
                            <button type="button" class="btn btn-rounded btn-primary btn-lg" id="printOrder"><i class="mdi mdi-printer"></i> Print</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderItems = document.getElementById('order-items');
        const addMoreItemsButton = document.getElementById('addMoreItems');
        const addNewCustomerButton = document.getElementById('addNewCustomer');
        const newCustomerFields = document.getElementById('newCustomerFields');
        const discountSwitch = document.getElementById('discountSwitch');
        const discountFields = document.getElementById('discountFields');
        const totalAmountElement = document.getElementById('totalAmount');
        const discountedTotalElement = document.getElementById('discountedTotal');
        const discountType = document.getElementById('discountType');
        const discountValue = document.getElementById('discountValue');

        addMoreItemsButton.addEventListener('click', function() {
            const orderItemTemplate = `
                <div class="form-group row order-item">
                    <label for="product" class="col-sm-3 col-form-label">Product</label>
                    <div class="col-sm-6">
                        <select class="form-control product-select" name="products[]">
                            <option value="">Choose product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="quantity" class="col-sm-1 col-form-label">Quantity</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control quantity-input" name="quantities[]" placeholder="Quantity">
                    </div>
                </div>`;
            orderItems.insertAdjacentHTML('beforeend', orderItemTemplate);
        });

        addNewCustomerButton.addEventListener('click', function() {
            newCustomerFields.style.display = newCustomerFields.style.display === 'none' ? 'block' : 'none';
        });

        discountSwitch.addEventListener('change', function() {
            discountFields.style.display = this.checked ? 'block' : 'none';
        });

        orderItems.addEventListener('input', updateTotalAmount);
        discountType.addEventListener('change', updateTotalAmount);
        discountValue.addEventListener('input', updateTotalAmount);

        function updateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.order-item').forEach(item => {
                const productSelect = item.querySelector('.product-select');
                const quantityInput = item.querySelector('.quantity-input');
                const price = productSelect.options[productSelect.selectedIndex].getAttribute('data-price');
                const quantity = quantityInput.value;

                if (price && quantity) {
                    totalAmount += price * quantity;
                }
            });

            totalAmountElement.textContent = `$${totalAmount.toFixed(2)}`;

            if (discountSwitch.checked) {
                let discount = 0;
                if (discountType.value === 'percentage') {
                    discount = (discountValue.value / 100) * totalAmount;
                } else if (discountType.value === 'amount') {
                    discount = discountValue.value;
                }
                const discountedTotal = totalAmount - discount;
                discountedTotalElement.textContent = `$${discountedTotal.toFixed(2)}`;
            } else {
                discountedTotalElement.textContent = `$${totalAmount.toFixed(2)}`;
            }
        }
    });
</script>
@endsection