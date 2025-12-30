@props([
'eror' => '',
'erorTitle' => '',
'erorDescription' => '',
])

<div bodyClass="bg-gray-200">
  <div class="page-header justify-content-center min-vh-100"
      style="
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container text-center">
          <div class="row" style="padding-top: 10%;">
              <div class="col-md-12">
                <h1 class="title text-light">{{ $eror }}</h1>
                <h2 class="text-light">{{ $erorTitle }}</h2>
                <h4 class="text-light">{{ $erorDescription }}</h4>
              </div>
            </div>
      </div>
  </div>
</div>