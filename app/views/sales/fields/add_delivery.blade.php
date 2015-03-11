<div class="form-group col-md-12 col-sm-12 " >

    @include('deliveries/fields/delivery_date')

</div>

<div class="form-group col-md-12 col-sm-12 " >

    @include('deliveries/fields/address')

</div>

<div class="form-group col-md-12 col-sm-12 " >

    @include('deliveries/fields/destination')

</div>

<span class="col-md-12 col-sm-12 text-center">ó</span>

<div class="form-group col-md-12 col-sm-12">

    @include('deliveries/fields/new_destination')


</div>

<div ng-if="newDestination">

    @include('deliveries/fields/new_destination_form')

</div>

<div class="form-group col-md-12 col-sm-12 " >

    @include('deliveries/fields/employee_id')

</div>