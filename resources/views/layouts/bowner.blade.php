<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Business Owner Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/libs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/libsstyle.css') }}" rel="stylesheet">

    {{--<script src="//cdn.ckeditor.com/4.5.10/standard/ckeditor.js"></script>--}}

    @yield('styles')

</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
         <!-- sidebar menu -->

                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <!--<h3>{{ Auth::user()->role->name }}</h3>-->
                        <ul class="nav side-menu">
                            <li><a href="{{url('/')}}" class="">
                                <img style="    width: auto;
    margin-top: -10px;
    margin-left: 15px;
    margin-right: 15px;
    height: 30px;" src="{{ asset('images/logo.jpg') }}"></a>
                                
                                </li>
                                  
                            
                           
                            
                            
                             @if(Auth::user()->access == 'production' || Auth::user()->access == 'super_manager')
                                <li><a href="{{ route('production.index') }}"><i class="fa fa-industry"></i> Production <span class="fa fa-industry"></span></a>
                                </li>
                            @else
                                <li><a href="#"><i class="fa fa-industry"></i> Production <span class="fa fa-industry"></span></a>
                                </li>
                            @endif                

                            @if(Auth::user()->access == 'super_manager' || Auth::user()->access == 'hr_manager')
                            <li><a href="{{ route('bowner.humans.index') }}"><i class="fa fa-users"></i> Human Resource </a>
                                <!--<ul class="nav child_menu">
                                    <li><a >All Employees</a></li>
                                    <li><a href="{{ route('bowner.humans.create') }}">Add Employee</a></li>
                                    <li><a href="{{ route('bowner.salaries.index') }}">Salary</a></li>
                                    <li><a href="{{ route('bowner.leaves.index') }}">Leave</a></li>
                                </ul>-->
                            </li> 

                            @endif 

                            @if(Auth::user()->access == 'super_manager' || Auth::user()->access == 'inv_manager')
                            
                            <li><a href="{{ route('bowner.inventories.index') }} "><i class="fa fa-cubes" ></i>Inventory</a>
                                
                            </li>

                             @endif 

                            <li class="" style="    float: right;
    margin-right: 2%;
    margin-top: 10px;">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->photo ? URL::asset(Auth::user()->photo->file) : URL::asset('/images/user.png') }}" alt="">{{ Auth::user()->name }}
                                <span class="fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <!--
                                <li><a href="javascript:;"> Profile</a></li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">100%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                -->
                                <li>
                                    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                </li>
                            </ul>
                        </li>
                        </ul>
                    </div>


                </div>
                <!-- /sidebar menu -->
        <div class="col-md-12">
           
               

              
                <!-- /menu footer buttons -->
            </div>
        </div>

    

        <!-- page content -->
        <div class="col-lg-12" role="main" >
            <div class="content" style="padding: 1rem 1rem;">
                @yield('content')
            </div>
            
            <div class="bg-footer">
            </div>
        </div>
        <!-- /page content -->
        
        <!-- footer content -->
         <!--<footer>
         
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
          
            <div class="clearfix"></div>

            {{-- @yield('footer') --}}
        </footer>
        /footer content -->
    </div>
</div>

<script src="{{ asset('js/libs.js') }}"></script>
@yield('scripts')
<script>
    $(document).ready(function(){
        //CKEDITOR.replace('body');

        // Initialize tooltip
        $('[data-toggle="tooltip"]').tooltip();

        $alert = $(".alert-message");

        if ($alert) {
            // Fade in alert when closing
            $alert.addClass("in");

            // Set auto fadein
            setTimeout(function(){
                $alert.fadeTo("slow", 0.1).slideUp("slow", function() {
                    $(this).remove();
                });
            }, 3000);
        }
    });
</script>

</body>
</html>