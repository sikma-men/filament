@extends('layouts.app')
@section('content')

  <body>
      <div class="container mt-5">
          <div class="row justify-content-center">
              <div class="col-md-4 mb-4">
                  <div class="card border-warning shadow-lg rounded-4" style="min-height: 250px;">
                      <div class="card-header bg-warning text-white text-center fw-bold">
                          Total Biaya Beban
                      </div>
                      <div class="card-body d-flex flex-column justify-content-center text-center">
                          <h3 class="text-warning">
                              Rp {{ number_format($totalBiayaBeban, 0, ',', '.') }}
                          </h3>
                      </div>
                  </div>
              </div>

              <div class="col-md-4 mb-4">
                  <div class="card border-primary shadow-lg rounded-4" style="min-height: 250px;">
                      <div class="card-header bg-primary text-white text-center fw-bold">
                          Total Biaya Pemakaian
                      </div>
                      <div class="card-body d-flex flex-column justify-content-center text-center">
                          <h3 class="text-primary">
                              Rp {{ number_format($totalBiayaPemakai, 0, ',', '.') }}
                          </h3>
                      </div>
                  </div>
              </div>

              <div class="col-md-4 mb-4">
                  <div class="card border-dark shadow-lg rounded-4" style="min-height: 250px;">
                      <div class="card-header bg-dark text-white text-center fw-bold">
                          Total Keseluruhan
                      </div>
                      <div class="card-body d-flex flex-column justify-content-center text-center">
                          <h3 class="text-dark">
                              Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                          </h3>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </body>
  </html>
  @endsection
