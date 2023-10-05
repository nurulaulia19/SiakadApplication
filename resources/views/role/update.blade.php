

{{-- bener --}}

@extends('layoutsAdmin.main')
@section('content')
    <div id="container" class="effect aside-float aside-bright mainnav-lg">
		@if (session('activated'))
                        <div class="alert alert-success" role="alert">
                            {{ session('activated') }}
                        </div>
                    @endif
            <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <div id="page-head">         
					<div class="pad-all text-center">
						<h3>Welcome back to the Dashboard</h3>
						<p>This is your experience to manage the Sistem Informasi Akademik Application</p>
					</div>
                </div>  
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
					    <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edit Role</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form action="{{ route('role.update', $dataRole->role_id) }}" method="POST">
                            
                                
                                    {{ csrf_field() }}
									{{-- @csrf --}}
									@method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="menu_name">Nama Role</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="role_name" id="menu_name" class="form-control" value="{{ $dataRole->role_name }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            
                                            <label class="col-sm-3 control-label" for="menu_link">Menu</label>
                                            
                                            <div class="col-sm-9">
                                                <div class="checkbox-container" style=" display: flex;
                                                flex-direction: column;">
                                                    @foreach ($dataMenu as $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="menu_id[]" type="checkbox" value="{{ $item->menu_id }}" {{ in_array($item->menu_id, $selectedMenuIds) ? 'checked' : '' }}>
                                                        <label class="form-check-label">{{ $item->menu_name }}</label>
                                                    </div>
                                                    @endforeach
                                                  </div>
                                            </div>
                                        </div>
                                        
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('role.index') }}" class="btn btn-secondary">KEMBALI</a>
                                            <button type="submit" class="btn btn-primary">SIMPAN</button>
                                            {{-- <button class="btn btn-success" type="submit">Edit</button> --}}
                                        </div>
                                        </div>
                                    </div>
                                    
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                                {{-- @endforeach --}}
                            </div>
                        </div>
                        @if(session('error'))
							<div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
				        @endif
					
					    
                </div>
                <!--===================================================-->
                <!--End page content-->

            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

			
       
        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->

    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection

{{-- @section('style')
<style>
    @if ($menu->menu_category=="master menu")
    #hidden_div {
    display: none ;
}
@else
#hidden_div {
    display: block ;
}
    @endif
    
</style>
@endsection

@section('script')
<script>
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 'sub menu' ? 'block' : 'none';
}
</script>

@endsection --}}




