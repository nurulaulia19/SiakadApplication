

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
                                    <h3 class="panel-title">Tambah Role</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                <form method="POST" action="/role/store">
                                    {{ csrf_field() }}
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="role_name">Nama Role</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Nama Role" name="role_name" id="role_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            
                                            <label class="col-sm-3 control-label" for="menu_link">Menu</label>
                                            
                                            <div class="col-sm-9">
                                                <div class="checkbox-container" style=" display: flex;
                                                flex-direction: column;">
                                                    @foreach ($dataMenu as $item)
                                                    <div class="form-check">
                                                      <input class="form-check-input" name="menu_id[]" type="checkbox" value="{{ $item->menu_id }}">
                                                      <label class="form-check-label">{{ $item->menu_name }}</label>
                                                    </div>
                                                    @endforeach
                                                  </div>
                                            </div>
                                           
                                        </div>
                                    <div class="panel-footer text-right">
                                        <a href="{{ route('role.index') }}" class="btn btn-secondary">KEMBALI</a>
                                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End Horizontal Form-->
                        
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

			

        </div>


        <!-- SCROLL PAGE BUTTON -->
        <!--===================================================-->
        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>
        <!--===================================================-->
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection

@section('style')
<style>
#hidden_div {
    display: none ;
}
</style>
@endsection

@section('script')
<script>
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 'sub menu' ? 'block' : 'none';
}
</script>

@endsection



