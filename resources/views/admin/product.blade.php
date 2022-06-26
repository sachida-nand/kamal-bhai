@extends('layouts.adminApp')
@section('title-section','Manage Product | Unique Electric Enterprises')
@section('content')
<script>
    const imageRemoveUrl = "{{ route('removeProductImageAjax') }}";
    const isFeaturedUpdateUrl = "{{ route('updateIsFeaturedProductAjax') }}";
    const isTrendingUpdateUrl = "{{ route('updateIsTrendingProduxctAjax') }}";
    const isTodayDealUpdateUrl = "{{ route('updateIsTodayDealProduxctAjax') }}";
    const changePublishedStatusUrl = "{{ route('changePublishedStatusAjax') }}";
    // const _token = $('meta[name="csrf-token"]').attr('content');
</script>
<div class="alert-section">
     {{-- @if ($message = Session::get('msg'))
   <div class="custome_alert alerts show">
        <span class="icon"><i class="far fa-check-circle"></i></span>
        <span class="msg">{{ $message }}</span>
        <span class="cross"><i class="fas fa-times"></i></span>
   </div>
   @endif --}}
  {{--  <div class="error_alert alerts show">
        <span class="icon"><i class="fas fa-exclamation"></i></span>
        <span class="msg">your product has been updated success 1</span>
        <span class="cross"><i class="fas fa-times"></i></span>
   </div> --}}
</div>

<div class="right_col" role="main">
        <div class="header">
        <h3>Product</h3>
    </div>

    @if ($message = Session::get('msg'))
    <div class="alert alert-primary w-50" role="alert">
        {{ $message }}
    </div>
    @endif
    <div>
        <button class="btn btn-primary" onclick="showAddFormSEction();">{{ $Mode == 'update' ? "Update Product" : "Add
            Product"}}</button>
    </div>
    
    <div id="form-section" class="{{ $errors->any() || $Mode ==  'update' ? 'active' : '' }}">
        <form action="{{ route('addAndUpdateProduct') }}" name="productForm" onsubmit="return formValidation()" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <div class="card">
                        <h5 class="header_infor">Product Information</h5>
                        @csrf
                        <input type="hidden" name="id" value="{{ $Mode ==  'update' ? $Products[0]->id : '' }}"
                            id="update">
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Catagorie <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group" id="catagorie">
                                    <select name="catagorie" class="selectpicker form-control" data-live-search="true">
                                        <option value="">Select Catagorie...</option>
                                        @foreach ($Catagories as $Catagorie )
                                            <option value="{{ $Catagorie->id }}" 
                                                {{ $Mode == 'update' && $Products[0]->catagorie_id == $Catagorie->id ? 'selected' : '' }}>
                                                {{ $Catagorie->catagorie_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <b><p class="error"></p></b>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Brand</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <select name="brand" class="selectpicker form-control" data-live-search="true">
                                        <option value="">Select Brand...</option>
                                        @foreach ($Brands as $Brand )
                                            <option value="{{ $Brand->id }}"
                                                {{$Mode == 'update' && $Products[0]->brand_id == $Brand->id ? 'selected' : '' }}>
                                                {{ $Brand->brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Product Name <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12" >
                                <div class="form-group" id="product_name">
                                    <input type="text" class="form-control" name="product_name"
                                     value="{{ $Mode == 'update' ? $Products[0]->product_name : old('product_name') }}"
                                         placeholder="Enter product name">
                                   <b><p class="error"></p></b>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Slug/URL <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12" >
                                <div class="form-group">
                                    <input type="text" id="slug" class="form-control" name="slug"
                                     value="{{ $Mode == 'update' ? $Products[0]->slug : old('slug') }}">
                                     @error('slug')
                                        <b><p class="error">{{ $message }}</p></b> 
                                     @enderror
                                   <b><p class="error"></p></b>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Minimum Purchase Qty <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12" >
                                <div class="form-group" id="minimum">
                                    <input type="text" class="form-control" name="min_purch_qty"
                                     value="{{ $Mode == 'update' ? $Products[0]->minimum_purchage_qty : old('min_purch_qty') }}" 
                                        placeholder="Enter Minimum Quantity in number">
                                <b><p class="error"></p></b>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label for="barcode">Barcode</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="barcode" name="barcode"
                                     value="{{ $Mode == 'update' ? $Products[0]->barcode : old('barcode') }}" 
                                        placeholder="Enter Barcode">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label for="refund">Refundable between</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="refund" name="refund_day"
                                     value="{{ $Mode == 'update' ? $Products[0]->refund_day : old('refund_day') }}" 
                                        placeholder="Enter day of refund in number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                         <h5 class="header_infor">Product Images </h5>
                        {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                    <label for="brand_logo">Thumbnail Image <span class="text-danger">*</span></label>                            
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                    <input type="file" class="form-control" id="thumbnail_img" value="" name="thumbnail_img" onchange="previewImageBeforeUpload('thumbnail_img')" placeholder="">
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="row">
                            <div class="col-lg-3 col-sm-12">

                            </div>
                            <div class="col-lg-9 col-sm-12">
                               <div id="image_preview" class="image_preview">
                                    @if ($Mode == 'update' && $Products[0]->thumbnail_img != '')
                                    <div>
                                        <img src="{{ asset('storage/product_images/'.$Products[0]->thumbnail_img) }}" alt="1">
                                        <span class="cancel" data='thumbnail' id="{{ $Products[0]->id }}">&#10060;</span>
                                    </div>
                                    @endif 
                                </div>
                            </div>
                        </div>
                         --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3 col-sm-12">
                                   <label for="Product_img">Product Images <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                   <input type="file" class="form-control" id="Product_img" value="" name="Product_img[]" onchange="previewFiles()" multiple>
                                   <small>Select atleast one image. Image type jpg/jpeg/png and size less then 5 mb</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">

                            </div>
                            <div class="col-lg-9 col-sm-12">
                               <div id="image_previews" class="image_preview">
                                   @if (!empty($ProductImages))
                                      @foreach ($ProductImages as $image)
                                            <div>
                                                <img src="{{ asset('storage/product_images/'.$image->image) }}" alt="1">
                                                <span class="cancel" data='gallery' id="{{ $image->id }}">&#10060;</span>
                                            </div> 
                                      @endforeach
                                   @endif  
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Product videos</h5>
                        <div class="form-group">
                            <label for="video_link">Video Link </label>
                            <input type="text" class="form-control" id="video_link" name="video_link"
                             value="{{ $Mode == 'update' ? $Products[0]->video_link : old('video_link') }}" 
                                placeholder="Video Link">
                            <small>Use proper link without extra parameter. Don't use short share link/embeded iframe
                                code.</small>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Product price + stock</h5>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Unit price <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group" id="unit_price">
                                    <input type="text" class="form-control" name="unit_price"
                                      value="{{ $Mode == 'update' ? $Products[0]->unit_price : old('unit_price') }}" 
                                        placeholder="Unit Price">
                                  <b><p class="error"></p></b>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Discount</label>  
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group" id="dicount">
                                    <input type="text" class="form-control" name="discount"
                                     value="{{ $Mode == 'update' ? $Products[0]->discount : old('discount') }}" 
                                       placeholder="Discount">
                                <b><p class="error"></p></b>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <select name="discount_type" class="form-control">
                                    <option value="flat" {{ $Mode == 'update' && $Products[0]->discount_type == 'flat' ? 'selected' : '' }}>Flat</option>
                                    <option value="percentage" {{ $Mode == 'update' && $Products[0]->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <div class="form-group" id="discounted_price">
                                    <input type="text" name="discount_price" class="form-control" 
                                     value="{{ $Mode == 'update' ? $Products[0]->discounted_price : old('discount_price') }}" 
                                    placeholder="00.00" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Quantity <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group" id="quantity">
                                    <input type="text" class="form-control" name="quantity"
                                     value="{{ $Mode == 'update' ? $Products[0]->quantity : old('quantity') }}" 
                                        placeholder="Quantity">
                                <b><p class="error"></p></b>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label for="sku">SKU</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="sku" name="sku"
                                     value="{{ $Mode == 'update' ? $Products[0]->sku : old('sku') }}" 
                                        placeholder="SKU">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Product Description</h5>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <textarea name="description" id="description">
                                        {{ $Mode == 'update' ? $Products[0]->product_description : old('description') }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">SEO Meta Tags</h5>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label for="tags">Meta Tags</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tags" name="tags"
                                     value="{{ $Mode == 'update' ? $Products[0]->tags : old('tags') }}" 
                                        placeholder="Enter Tags">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label for="meta_desc">Meta Description</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <textarea class="form-control" id="meta_desc" name="meta_description" rows="3">{{ $Mode == 'update' ? $Products[0]->meta_description : old('meta_desc') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-sm-12">
                    <div class="card">
                        <h5 class="header_infor">Shipping Configuration</h5>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>free shipping</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <input type="radio" name="shipping" onclick="showShpmentArea(this);" value="yes" checked>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>flat rate</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <input type="radio" name="shipping" onclick="showShpmentArea(this);" value="no"
                                      {{ $Mode == 'update' && $Products[0]->free_shipping == 'no' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div id="shipment" 
                                class="{{ $Mode == 'update' && $Products[0]->free_shipping == 'no' ? 'active' : '' }}">
                            <div class="row">
                                 <div class="col-lg-6 col-sm-12">
                                       <div class="form-group">
                                          <label for="shipping_cost">Shipping Cost</label>
                                       </div>
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                       <div class="form-group">
                                          <input type="text" class="form-control" name="shipping_cost" id="shipping_cost"
                                            value="{{ $Mode == 'update' ? $Products[0]->shipping_cost : '' }}" placeholder="0">
                                       </div>
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="col-lg-6 col-sm-12">
                                       <div class="form-group">
                                          <label>Is Product Quantity Mulitiply</label>
                                       </div>
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                       <div class="form-group">
                                          <input type="checkbox" class="form-control" name="is_qty_mply" value="yes"
                                             {{ $Mode == 'update' && $Products[0]->is_qty_mply == 'yes' ? 'checked' : '' }}>
                                       </div>
                                 </div>
                              </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Low Stock Quantity Warning</h5>
                        <div>
                           <div class="form-group">
                            <label for="low_stock_warning">Quantity</label>
                            <input type="text" class="form-control" id="low_stock_warning" name="stock_warning"
                              value="{{ $Mode == 'update' ? $Products[0]->stock_warnning : 1 }}">
                        </div> 
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Cash on Delivery</h5>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Status</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" name="cash_on_delivery" value="yes"
                                        {{ $Mode == 'update' && $Products[0]->cash_on_delivery == 'yes' ? 'checked' : '' }} {{ $Mode != 'update' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Is Featured</h5>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Status</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" name="is_featured" value="yes"
                                        {{ $Mode == 'update' && $Products[0]->is_featured == 'yes' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Is trending</h5>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Status</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" name="is_trending" value="yes"
                                        {{ $Mode == 'update' && $Products[0]->is_trending == 'yes' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Todays Deal</h5>
                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>Status</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" name="today_deal" value="yes"
                                        {{ $Mode == 'update' && $Products[0]->today_deal == 'yes' ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group">
                                    <label>End date</label>
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="today_deal_end">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <h5 class="header_infor">Estimate Shipping Time</h5>
                           <div class="form-group">
                            <label for="ship_day">Shipping Days</label>
                              <input type="text" class="form-control" name="est_shipping_time" id="ship_day"
                               value="{{ $Mode == 'update' ? $Products[0]->est_shipping_time : 7 }}"
                               placeholder="0">
                          </div> 
                    </div>
                </div>
                <div class="col-lg-8 col-sm 12">
                     <div class="text-right">
                    <button type="submit" name="publish" class="btn btn-success px-4 mt-2">{{ $Mode == 'update' ? 'Update &
                        Publish' :
                        'Save & Publish'}}</button>
                    <button type="submit" name="unpublish" class="btn btn-warning px-4 mt-2">{{ $Mode == 'update' ? 'Update &
                        Unpublish' :
                        'Save & Unpublish'}}</button>
                </div>
                </div>
            </div>
        </form>
    </div>

    <div class="show_item_section card">
        <div class="card-box table-responsive-lg">
            <table id="datatable" class="table table-bordered table-hover" >
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Info</th>
                        <th>Stock</th>
                        <th>Unit Price</th>
                        <th>Dicount</th>
                        <th>Selling Price</th>
                        <th>Is Featured</th>
                        <th>Is Trending</th>
                        <th>Today deal</th>
                        <th>Published</th>
                        <th >Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach ($Products as $Product)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $Product->product_name }}</td>
                        <td>
                           <b>No of Sales: </b>50 <br>
                           <b>Rating: </b>Not
                        </td>
                        <td>
                            {{ $Product->quantity }}
                        </td>
                        <td>{{ $Product->unit_price }}</td>
                        <td>{{ $Product->discount != null  ? $Product->discount : 'Not Discount' }}</td>
                        <td>{{ $Product->discounted_price != null  ? $Product->discounted_price :  $Product->unit_price }}</td>
                        <td>
                            <div class="" style="position: relative;">
                             <input type="checkbox" class="form-control table_check" name="is_featured" id="{{ $Product->id }}" {{ $Product->is_featured == 'yes' ? 'checked' : '' }}>
                            </div>
                        <td>
                            <div class="" style="position: relative;">
                               <input type="checkbox" class="form-control table_check" name="is_trending" id="{{ $Product->id }}"
                                    {{ $Product->is_trending == 'yes' ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <div class="" style="position: relative;">
                               <input type="checkbox" class="form-control table_check" name="today_deal" id="{{ $Product->id }}"
                                    {{ $Product->today_deal == 'yes' ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <div class="" style="position: relative;">
                               <input type="checkbox" class="form-control table_check" name="status" id="{{ $Product->id }}" {{ $Product->status == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <a href="{{ url('product/edit/'.$Product->id) }}" data-toggle="tooltip" data-placement="top" title="Edit Product" class="btn btn-info"><i class="fas fa-edit"></i></a>
                            <a href="{{ url('product-delete/'.$Product->id) }}" data-toggle="tooltip" data-placement="top" title="Delete Product" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="View Details" class="btn btn-danger"><i class="fas fa-eye"></i></a>
                            {{-- @if ($Product->status == 1)
                            <a href="{{ url('Product-status/status/active/'.$Product->id) }}" class="btn btn-success">
                                Active
                            </a>
                            @else
                            <a href="{{ url('Product-status/status/deactive/'.$Product->id) }}"
                                class="btn btn-warning text-dark">
                                Deactive
                            </a>
                            @endif --}}

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
    @section('script')
    <script>
        CKEDITOR.replace('description');

        $('#product_name input').change(function(){
            $.get('{{ route('setSlug') }}',
                {'name': $(this).val(), type: 'product' },
                function(data){
                    $('#slug').val(data.slug);
                }
            );
        })
    </script>
    @endsection