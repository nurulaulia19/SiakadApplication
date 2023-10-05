

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
                                    <h3 class="panel-title">Edit Menu</h3>
                                </div>
                        
                                <!--Horizontal Form-->
                                <!--===================================================-->
                                {{-- @foreach ( $dataMenu as $item)  --}}
                                    
                                
								<form action="{{ route('menu.update', $menu->menu_id) }}" method="POST">
                            
                                {{-- <form method="POST" action="{{ route('menu.update') }}"> --}}
                                    {{ csrf_field() }}
									{{-- @csrf --}}
									@method('PUT')
                                    <div class="panel-body">
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="menu_name">Nama Menu</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="menu_name" id="menu_name" class="form-control" value="{{ $menu->menu_name }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="menu_link">Link Menu</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="Link Menu" name="menu_link" id="menu_link" class="form-control" value="{{ $menu->menu_link }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="menu_category">Kategori Menu</label>
											<div class="col-sm-9">
												<select class="form-control" name="menu_category" id="menu_category" onchange="showDiv('hidden_div', this)">
                                                     @if ($menu->menu_category=="master menu")
                                                     <option selected value="master menu">Master Menu</option>
                                                     <option value="sub menu">Sub Menu</option>
                                                     @else
                                                     <option value="sub menu">Sub Menu</option>
                                                     <option value="master menu">Master Menu</option>
                                                     @endif
                                    
													
												</select>
											</div>
                                        </div>
                                        <div id="hidden_div">
											<div class="form-group d-flex mb-3">
                                                <label class="col-sm-3 control-label" for="menu_sub">Sub Menu</label>
                                                <div class="col-sm-9">
                                                    <select placeholder="Sub Menu" name="menu_sub" id="menu_sub" class="form-control">
                                                        <option value="">Pilih Sub Menu</option> {{-- Opsi kosong di sini --}}
                                                        @foreach ($dataMenu as $item)
                                                            <option value="{{ $item->menu_id }}" {{ $item->menu_id == $menu->menu_sub ? 'selected' : '' }}>{{ $item->menu_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>	
                                            </div>                                            
										</div>
                                        <div class="form-group d-flex mb-3">
                                            <label class="col-sm-3 control-label" for="menu_position">Posisi Menu</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="menu_position" id="menu_position" class="form-control" value="{{ $menu->menu_position }}">
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <a href="{{ route('menu.index') }}" class="btn btn-secondary">KEMBALI</a>
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

@section('style')
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

@endsection




