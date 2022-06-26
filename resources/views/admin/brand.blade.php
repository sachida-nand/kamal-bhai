@extends('layouts.adminApp')
@section('title-section','Manage Brand | Unique Electric Enterprises')
@section('content')
<div class="right_col" role="main">
    <div class="header">
        <h3>Brand</h3>
    </div>

     @if ($message = Session::get('msg'))
        <div class="alert alert-primary w-50" role="alert">
            {{ $message }}
        </div>
     @endif
   <div>
       <button class="btn btn-primary" onclick="showAddFormSEction();">{{ $Mode ==  'update' ? "Update Brand" : "Add Brand"}}</button>
   </div>

   <div id="form-section" class="{{ $errors->any() || $Mode ==  'update' ? 'active' : '' }}">
       <div class="card">
           <div class="row">
               <div class="col-lg-6 col-sm-12">
                   <form action="{{ route('addAndUpdateBrand') }}" method="POST" id="form" enctype="multipart/form-data">
                       @csrf
                       <input type="hidden" name="id" value="{{ $Mode ==  'update' ? $Brands[0]->id : '' }}" id="update">
                        <div class="form-group">
                            <label for="brand_name">Brand Name  *</label>
                            <input type="text" class="form-control" id="brand_name" value="{{ $Mode ==  'update' ? $Brands[0]->brand_name : old('brand_name') }}" name="brand_name" placeholder="Enter a brand name" required>
                        </div>
                        @error('brand_name')
                            <div class="text-danger">
                                 {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="slug" value="{{ $Mode ==  'update' ? $Brands[0]->brand_name : old('slug') }}" name="slug" required>
                        </div>
                        <div class="form-group">
                            <label for="brand_logo">Brand Logo *</label>
                            <input type="file" class="form-control" id="brand_logo" value="{{ $Mode ==  'update' ? $Brands[0]->brand_logo : '' }}" name="brand_logo" onchange="previewImageBeforeUpload('brand_logo')" placeholder="">
                        </div>
                        <div id="image_preview">
                            @if ($Mode == 'update' && $Brands[0]->brand_logo != '')
                                <div>
                                <img src="{{ asset('storage/media/'.$Brands[0]->brand_logo) }}" alt="1">
                                <span class="cancel" id="{{ $Brands[0]->id }}">&#10060;</span>
                            </div>
                            @endif 
                        </div>
                        <button type="submit" class="btn btn-primary px-4 mt-2">{{ $Mode ==  'update' ? 'Update' : 'Save' }}</button>
                    </form>
               </div>
           </div>
       </div>
   </div>

   <div class="show_item_section card">
    <div class="card-box table-responsive">
        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @forelse ($Brands as $Brand)
                 <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $Brand->brand_name }}</td>
                    <td>
                    @if ($Brand->brand_logo !="")
                     <img src="{{ asset('storage/media/'.$Brand->brand_logo) }}" id="remove" alt="logo" width="70">
                    @endif    
                    </td>
                    <td>
                        <a href="{{ url('brand/edit/'.$Brand->id) }}" class="btn btn-info">Edit</a>
                        <a href="{{ url('brand-delete/'.$Brand->id) }}" class="btn btn-danger">Delete</a>
                        @if ($Brand->status == 1)
                             <a href="{{ url('brand-status/status/active/'.$Brand->id) }}" class="btn btn-success">
                               Active
                             </a>
                        @else
                            <a href="{{ url('brand-status/status/deactive/'.$Brand->id) }}" class="btn btn-warning text-dark">
                                Deactive
                            </a>
                        @endif
                       
                    </td>
                </tr>
                @empty
                    <h2>Data Not Found</h2>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    const imageRemoveUrl = "{{ route('removeBrandImage') }}";
    const _tokenn   = $('meta[name="csrf-token"]').attr('content');
    $(document).on("click",".cancel",function(){
    if($(this).attr("id")>0)
    {
      $_this = $(this);
      brandImageId = $(this).attr("id");
      $.ajax({
        url: imageRemoveUrl,
        method: 'POST',
        data : { "brandImageId":brandImageId,"_token": _tokenn },
        dataType : "json",
        success: function(result)
        {
          if(result.status=="success")
          {
              $('#remove').remove();
            $_this.closest("div").remove();
          }
        }
      });
    }
    else
    {
      document.getElementById('brand_logo').value = '';
      $(this).closest("div").remove();
    }
  });

  $('#brand_name').keyup(function(){
    //   console.log('chhkdhfkd');
      $.get('{{ route('setSlug') }}',
         {'name': $(this).val(), type: 'brand' },
         function(data){
            //  console.log(data);
             $('#slug').val(data.slug);
         }
      );
  })
</script>
@endsection
