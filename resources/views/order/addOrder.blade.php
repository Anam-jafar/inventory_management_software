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
                                <select class="form-control product-select custom-select" id="product" name="products[]">
                                    <option value="">Choose product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-available-quantity="{{ $product->quantity }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="quantity" class="col-sm-1 col-form-label">Quantity</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control quantity-input" id="quantity" name="quantities[]" placeholder="Quantity">
                            </div>
                            <div class="col-sm-12">
                                <span class="text-danger error-message" style="display: none;">Quantity needs to be between 1 and available quantity.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 d-flex justify-end">
                            <a class="btn btn-secondary btn-sm plus-button" id="addMoreItems"><i class="mdi mdi-plus"></i></a>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="form-group row">
                        <label for="customer" class="col-sm-3 col-form-label">Choose Customer</label>
                        <div class="col-sm-6">
                            <select class="form-control custom-select" id="customer" name="customer_id">
                                <option value="">Choose customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 d-flex justify-start">
                            <a id="addNewCustomer">New Customer</a>
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
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="discountSwitch">
                                <label class="form-check-label" for="discountSwitch"></label>
                            </div>
                        </div>
                    </div>
                    <div id="discountFields" style="display:none;">
                        <div class="form-group row">
                            <label for="discountType" class="col-sm-3 col-form-label">Discount Type</label>
                            <div class="col-sm-3">
                                <select class="form-control custom-select" id="discountType" name="discount_type">
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
                            <a href="#" class="btn btn-rounded btn-danger btn-lg" id="printOrder"><i class="mdi mdi-cancel"></i> Cancel</a>
                            <button type="submit" class="btn btn-rounded btn-success btn-lg " id="saveButton"><i class="mdi mdi-content-save"></i> Save</button>
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
        const saveButton = document.getElementById('saveButton');

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

        function checkQuantity(productSelect, quantityInput) {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const availableQuantity = parseInt(selectedOption.getAttribute('data-available-quantity'));
            const inputQuantity = parseInt(quantityInput.value);
            const errorMessage = productSelect.closest('.order-item').querySelector('.error-message');

            if (inputQuantity <= 0 || inputQuantity > availableQuantity) {
                errorMessage.style.display = 'inline';
                quantityInput.classList.add('is-invalid');
                saveButton.disabled = true;
            } else {
                errorMessage.style.display = 'none';
                quantityInput.classList.remove('is-invalid');
                saveButton.disabled = false;
            }
        }

        function addEventListenersToNewItem(item) {
            const productSelect = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');

            productSelect.addEventListener('change', function() {
                checkQuantity(productSelect, quantityInput);
                updateTotalAmount();
            });

            quantityInput.addEventListener('input', function() {
                checkQuantity(productSelect, quantityInput);
                updateTotalAmount();
            });
        }

        addMoreItemsButton.addEventListener('click', function() {
            const orderItemTemplate = `
                <div class="form-group row order-item">
                    <label for="product" class="col-sm-3 col-form-label">Product</label>
                    <div class="col-sm-6">
                        <select class="form-control product-select custom-select" name="products[]">
                            <option value="">Choose product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-available-quantity="{{ $product->quantity }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="quantity" class="col-sm-1 col-form-label">Quantity</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control quantity-input" name="quantities[]" placeholder="Quantity">
                    </div>
                    <div class="col-sm-12">
                        <span class="text-danger error-message" style="display: none;">Quantity needs to be between 1 and available quantity.</span>
                    </div>
                </div>`;
            orderItems.insertAdjacentHTML('beforeend', orderItemTemplate);

            const newItem = orderItems.lastElementChild;
            addEventListenersToNewItem(newItem);
        });

        addNewCustomerButton.addEventListener('click', function() {
            newCustomerFields.style.display = newCustomerFields.style.display === 'none' ? 'block' : 'none';
        });

        discountSwitch.addEventListener('change', function() {
            discountFields.style.display = this.checked ? 'block' : 'none';
            updateTotalAmount();
        });

        orderItems.addEventListener('input', updateTotalAmount);
        discountType.addEventListener('change', updateTotalAmount);
        discountValue.addEventListener('input', updateTotalAmount);

        // Initial setup for the first item
        document.querySelectorAll('.order-item').forEach(addEventListenersToNewItem);
    });
</script>


@endsection
