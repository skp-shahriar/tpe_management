<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title ?? 'Rent Management System'}}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo/3rd_party_employee.png') }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @yield('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand d-flex align-items-start flex-column active-nav" id="sidebar">
            <a href="{{ asset('') }}" class="navbar-brand text-light mx-3 mt-3 align-self-center border-bottom">
              <img src="{{ asset('img/logo/logo.png') }}" alt="" height="50px">
            </a>
              <h5 class="fw-bold my-2 text-center ">Third Party Employee Management</h5>
              <div class="b-example-divider"></div>
            
            @guest
                @if (Route::has('login'))
                    <p class="mx-2 mt-2 fw-bold">The nation was just halfway of its age; the passion for history and heritage and an obsession for faster pace exerted a powerful force for change in the business world. Many budding hopes grew as a choice of the new generation in the shadows of banking reformation of the Nineties. Dhaka Bank is such a dream that spread in profusion modern banking prospects with deep attachment to its community and culture. A host of visionary entrepreneur friends inspired by a futurist leader set forth the fight of this great corporate voyage that echoed the speed of technology on the inner soul of Bangladesh.</p>
                    <p class="mx-2 fw-bold">Copyright ?? 2022 Dhaka Bank Limited</p>
                @endif
            @else
            <ul class="list-unstyled ms-2 mt-4 ps-0 w-75">
            @if (!empty($menu))
            
              @foreach ($menu as $m)
                @if (isset($m->sub_menu))
                  <li class="mb-2">
                    <button
                      class="btn btn-toggle align-items-center rounded collapsed w-100" data-bs-toggle="collapse" data-bs-target="#{{$m->permission_name}}" aria-expanded="false">
                      {{ucfirst(str_replace("_"," ",$m->menu_name))}}
                    </button>
                    <div class="collapse  mt-1" id="{{$m->permission_name}}">
                      <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ">
                        
                        @foreach ($m->sub_menu as $sm)
                          @if (isset($sm->sub_menu_II))
                            <li>
                              <button class="btn btn-toggle align-items-center rounded collapsed w-100 ms-3" data-bs-toggle="collapse" data-bs-target="#{{$sm->permission_name}}" aria-expanded="false">
                              {{ucfirst(str_replace("_"," ",$sm->menu_name))}}
                              </button>
                              <div class="collapse  mt-1 ms-2" id="{{$sm->permission_name}}">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ">
                                  @foreach ($sm->sub_menu_II as $sm_II)
                                  
                                    @if (isset($sm_II->sub_menu_III))
                                      <li>
                                        <button class="btn btn-toggle align-items-center rounded collapsed w-100 ms-3" data-bs-toggle="collapse" data-bs-target="#{{$sm_II->permission_name}}" aria-expanded="false">
                                          {{ucfirst(str_replace("_"," ",$sm_II->menu_name))}}
                                        </button>
                                          <div class="collapse  mt-1 ms-2" id="{{$sm_II->permission_name}}">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 ">
                                              @foreach ($sm_II->sub_menu_III as $sm_III)
                                                <li><a href="{{route($sm_III->route_name)}}" class="link-dark rounded w-100">{{ucfirst(str_replace("_"," ",$sm_III->menu_name))}}</a></li>
                                              @endforeach
                                            </ul>
                                          </div>
                                      </li>
                                    @else
                                    <li><a href="{{route($sm_II->route_name)}}" class="link-dark rounded w-100">{{ucfirst(str_replace("_"," ",$sm_II->menu_name))}}</a></li>
                                    @endif
                                  @endforeach
                                </ul>
                              </div>
                            </li>
                          @else
                          <li><a href="{{route($sm->route_name)}}" class="link-dark rounded w-100">{{ucfirst(str_replace("_"," ",$sm->menu_name))}}</a></li>
                          @endif
                        @endforeach
                      </ul>
                    </div>
                  </li>
                @else
                      <li><a href="{{route($m['route_name'])}}" class="btn btn-toggle link-dark  rounded w-100">{{ucfirst(str_replace("_"," ",$m['menu_name']))}}</a></li>
                @endif
              @endforeach
            @endif
            </ul>
            @endguest
        </nav>
        <section class="my-container active-cont">
            <div class="top-brand text-center d-none">
                <a href="{{ asset('') }}" >
                    <img class="m-3" src="{{ asset('img/logo/logo.png') }}" alt="" height="40px">
                    <h3 class="d-inline-block">Third Party Employee Management</h3>
                </a>
            </div>
            <div id="top-header" class="text-center">
                    <button class="btn" id="menu-btn"><i class="fa-solid fa-bars"></i></button>
                    <h2 class="d-inline-block mt-3 top-title">{{$title ?? 'Third Party Employee Management'}}</h2>

                @guest   
                @else
                    <div class="d-inline logout">
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endguest
            </div>
            
            
            <main class="py-4">
                @yield('content')
            </main>
        </section>

    </div>

    <!-- Scripts -->
    @stack('scripts')
    @yield('script')
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
      $(document).on('click', ".active_inactive_btn", function() {
          // var status;
          // if ($(this).is(':checked')) {
          //     alert('checked');
          //     status = 7;                    
          // }else{
          //     status = -7;                   
          // }  

          var id = $(this).val();
          var status = $(this).attr('status');
          var field_id = $(this).attr('id');
          $.ajax({
              type: "GET",
              url: "{{ route('active.inactive') }}",
              dataType: "json",
              data: {
                  id: id,
                  status: $(this).attr('status'),
                  table: $(this).attr('table')
              },
              success: function(response) {
                  if (response.status == 'success') {
                      Toast.fire({
                          icon: 'success',
                          title: response.message
                      })
                      $("#" + field_id).attr('status', response.changed_value);
                      if (response.changed_value == -7) {
                          $('#edit_btn_' + field_id).prop('disabled', true);
                      } else if (response.changed_value == 7) {
                          $('#edit_btn_' + field_id).prop('disabled', false);
                      }
                  } else if (response.status == 'not_success') {
                      var $checkbox = $("#" + field_id);
                      ($checkbox.prop("checked") == true) ? $checkbox.prop("checked", false):
                          $checkbox.prop("checked", true);
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: response.message,
                      });
                      return false;
                  }
              },
              error: function(xhr, status, error) {
                  // handle error
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: error,
                  });
                  return false;
              }
          })

      });
  </script>
    
</body>

</html>