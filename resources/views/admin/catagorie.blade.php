@extends('layouts.adminApp')
@section('title-section','Manage Catagory | Unique Electric Enterprises')
@section('content')
<div class="right_col" role="main">
    <div class="header">
        <h3>Catagorie</h3>
    </div>

     @if ($message = Session::get('msg'))
        <div class="alert alert-primary w-50" role="alert">
            {{ $message }}
        </div>
     @endif
   <div>
       <button class="btn btn-primary" onclick="showAddFormSEction();">{{ $Mode ==  'update' ? "Update Catagorie" : "Add Catagorie"}}</button>
   </div>

   <div id="form-section" class="{{ $errors->any() || $Mode ==  'update' ? 'active' : '' }}">
       <div class="card">
           <div class="row">
               <div class="col-lg-6 col-sm-12">
                   <form action="{{ route('addAndUpdateCatagorie') }}" method="POST" enctype="multipart/form-data">
                       @csrf
                       <input type="hidden" name="id" value="{{ $Mode ==  'update' ? $Catagorie[0]->id : '' }}" id="">
                        <div class="form-group">
                            <label for="catagorie_name">Catagorie Name</label>
                            <input type="text" class="form-control" id="catagorie_name" value="{{ $Mode ==  'update' ? $Catagorie[0]->catagorie_name : old('catagorie_name') }}" name="catagorie_name" placeholder="Enter a Catagorie name" required>
                        </div>
                        @error('catagorie_name')
                            <div class="text-danger">
                                 {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">      
                            <input type="hidden" class="form-control" id="slug" value="{{ $Mode ==  'update' ? $Catagorie[0]->catagorie_name : old('slug') }}" name="slug" required>
                        </div>
                        <div class="form-group">
                            <label for="catagorie_logo">Catagorie Logo</label>
                            <input type="file" class="form-control" id="catagorie_logo" value="{{ $Mode ==  'update' ? $Catagorie[0]->catagorie_logo : '' }}" name="catagorie_logo" onchange="previewImageBeforeUpload('catagorie_logo')" placeholder="">
                        </div>
                        <div id="image_preview">
                            @if ($Mode == 'update' && $Catagorie[0]->catagorie_logo != '')
                                <div>
                                <img src="{{ asset('storage/media/'.$Catagorie[0]->catagorie_logo) }}" alt="1">
                                <span class="cancel" id="{{ $Catagorie[0]->id }}">&#10060;</span>
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
                @forelse ($Catagorie as $catagorie)
                 <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $catagorie->catagorie_name }}</td>
                    <td>
                    @if ($catagorie->catagorie_logo !="")
                     <img src="{{ asset('storage/media/'.$catagorie->catagorie_logo) }}" id="remove" alt="logo" width="70">
                    @endif    
                    </td>
                    <td>
                        <a href="{{ url('catagorie/edit/'.$catagorie->id) }}" class="btn btn-info">Edit</a>
                        <a href="{{ url('catagorie-delete/'.$catagorie->id) }}" class="btn btn-danger">Delete</a>
                        @if ($catagorie->status == 1)
                             <a href="{{ url('catagorie-status/status/active/'.$catagorie->id) }}" class="btn btn-success">
                               Active
                             </a>
                        @else
                            <a href="{{ url('catagorie-status/status/deactive/'.$catagorie->id) }}" class="btn btn-warning text-dark">
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
    const imageRemoveUrl = "{{ route('removeCatagorieImage') }}";
    const _tokenn   = $('meta[name="csrf-token"]').attr('content');
    $(document).on("click",".cancel",function(){
    if($(this).attr("id")>0)
    {
      $_this = $(this);
      catagorieImageId = $(this).attr("id");
      $.ajax({
        url: imageRemoveUrl,
        method: 'POST',
        data : { "catagorieImageId":catagorieImageId,"_token": _tokenn },
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
      document.getElementById('catagorie_logo').value = '';
      $(this).closest("div").remove();
    }
  });

  $('#catagorie_name').keyup(function(){
      $.get('{{ route('setSlug') }}',
         {'name': $(this).val(), type: 'catagorie' },
         function(data){
             console.log(data);
             $('#slug').val(data.slug);
         }
      );
  })
</script>
@endsection
