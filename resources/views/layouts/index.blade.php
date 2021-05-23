<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}" />  
    <meta name="description" content="" />
    <meta name="author" content="mualiyuoox@gmail.com" />
    <title>Farm Dashboard</title>
    <link href="{{asset('css/bootstrap.me.css')}}" rel="stylesheet" />
    <script src="{{asset('js/font.all.min.js')}}" crossorigin="anonymous"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    @yield('style')
   <style>
    #switchMode[type=checkbox]{
    	height: 0;
    	width: 0;
    	visibility: hidden;
    }

    #vvb {
    	cursor: pointer;
    	text-indent: -9999px;
    	width: 60px;
    	height: 30px;
    	background: grey;
    	display: block;
    	border-radius: 30px;
    	position: relative;
      margin-left: 5px;
    }

    #vvb:after {
    	content: '';
    	position: absolute;
    	top: 1px;
    	left: 1px;
    	width: 25px;
    	height: 28px;
    	background: #fff;
    	border-radius: 15px;
    	transition: 0.2s;
    }

    #switchMode:checked + #vvb {
    	background: green;
    }

    #switchMode:checked + #vvb:after {
    	left: calc(100% - 2px);
    	transform: translateX(-100%);
    }

    #vvb:active:after {
    	width: 40px;
    }
  </style>
    <style>
      @media only screen and (max-width: 800px) {
        .uname strong {
          display: none;
        }
      }
    </style>
  </head>
  <body class="sb-nav-fixed">
    <nav
      class="sb-topnav navbar navbar-expand"
      style="background: #1c3c3c; height: auto; color: white"
    >
      <button
        class="btn btn-link btn-sm order-1 order-lg-0"
        style="color: white; font-size: 22px"
        id="sidebarToggle"
        href="#"
      >
        <i class="fas fa-bars"></i>
      </button>
      <a class="navbar-brand" href="#" style="color: #ffffff; font-size: 20px">
        SmartFarm
        {{-- OPTIMIZED IOTs-BASED MODEL FOR AGRICULTURE AND WATER MANAGEMENT --}}
      </a>

      <!-- Navbar-->
      <ul
        class="navbar-nav ml-auto ml-md-0"
        style="right: 3px; position: absolute"
      >
        @guest
           @if (Route::has('login'))
               <li class="nav-item">
                   <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
               </li>
           @endif
        @else
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle uname"
              id="userDropdown"
              href="#"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
              style="color: white; font-size: 18px"
            >
              <strong>{{ Auth::user()->name }}</strong>
              <i class="fas fa-user fa-fw"></i>
            </a>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="userDropdown"
            >
              <a class="dropdown-item" href="#">Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
            </div>
          </li>
        @endguest
      </ul>
    </nav>

    <div id="layoutSidenav">
      @auth
      <div id="layoutSidenav_nav">
        <nav
          class="sb-sidenav accordion sb-sidenav-light"
          id="sidenavAccordion"
        >
          <div class="sb-sidenav-menu">
            <div class="nav">
              <div class="sb-sidenav-menu-heading"></div>
              <a class="nav-link" href="{{route('home')}}">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-tachometer-alt"></i>
                </div>
                Home
              </a>
              <a class="nav-link" href="{{route('actuators')}}">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-diagnoses"></i>
                </div>
                Actuators
              </a>
              <a class="nav-link" href="{{route('sensors')}}">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-thermometer-three-quarters"></i>
                </div>
                Sensors
              </a>
              <span class="nav-link" id="operationMode">
                <?php $system_statuss = \App\Models\System_status::orderBy('created_at', 'desc')->first(); ?>
                Operation Mode
                <input
                  id="switchMode"
                  class="operation"
                  data-id="{{$system_statuss->pump}}"
                  type="checkbox"
                   data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $system_statuss->mode ? 'checked' : '' }}
                /><label id="vvb" for="switchMode">Toggle</label>
              </span>
              {{-- {{$system_statuss->mode}} --}}
            </div>
          </div>
          <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{Auth::user()->email}}
          </div>
        </nav>
      </div>
      @endauth

      <div id="layoutSidenav_content">
        <main>
          @yield('content')
        </main>
      </div>
    </div>
    <script src="{{asset('js/jquery-3.5.1.min.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script>
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
      $(function() {

        $('.operation').change(function() {
            var pump = $(this).data('id'); 
            var mode = $(this).prop('checked') == true ? 1 : 0; 
            window.console.log(mode, pump);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{ route("publishStatusMode") }}',
                data: {'pumpStatus': pump, 'modeStatus': mode},
                success: function(data){
                  console.log(data.success)
                  // setInterval(function(){
                  //       location.load();
                  // }, 2000);
                }
            });
        });

        $('.toggle-class').change(function() {
            var pump = $(this).prop('checked') == true ? 1 : 0; 
            var mode = $(this).data('id'); 
             window.console.log(pump);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{ route("publishStatus") }}',
                data: {'pump': pump, 'mode': mode},
                success: function(data){
                  console.log(data.success)
                  // setInterval(location.reload(), 5000); 
                  // setInterval(function(){
                  //       location.load();
                  // }, 2000);

                }
            });
        })



      })

  </script>
    @yield('script')
  </body>
</html>
