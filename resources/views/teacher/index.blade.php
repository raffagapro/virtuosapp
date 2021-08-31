@extends('layouts.app')

@section('subBar')
  @php
    $crumbs = []
  @endphp

  <x-sub-bar :crumbs="$crumbs"/>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card bgVirtuos border-secondary text-light text-center py-5">
                <div class="card-body">
                    <div class="mx-auto mb-3">
						<span class="fa-stack fa-5x">
							<i class="fas fa-circle fa-stack-2x text-light" style="line-height: inherit"></i>
							<i class="fas fa-user fa-stack-1x text-secondary" style="line-height: inherit"></i>
						</span>
                    </div>
                    <h3 class="mb-0">{{ Auth::user()->name }}</h3>
                    <p class="text-white-50">Primaria 2 A</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th><h5>Clases</h5></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="align-middle"><a href="{{ route('maestroCourse') }}">Matemáticas</a></td>
                            <td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>
                          </tr>
                          <tr>
                            <td>Español</td>
                            <td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>
                          </tr>
                          <tr>
                            <td>Ciencias</td>
							<td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>                          </tr>
                          <tr>
                            <td>Artes Plásticas</td>
							<td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>                          </tr>
                          <tr>
                            <td>Música</td>
							<td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>                          </tr>
                          <tr>
                            <td>Coro</td>
							<td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>                          </tr>
                          <tr>
                            <td>Artes Escénicas</td>
							<td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>                          </tr>
                          <tr>
                            <td>Deportes</td>
							<td class="align-middle text-right py-0">
								<button type="button" class="btn btn-link">
									<span class="fa-stack fa-lg">
										<i class="fas fa-circle fa-stack-2x"></i>
										<i class="fas fa-video fa-sm fa-stack-1x fa-inverse"></i>
									</span>
								</button>
							</td>                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

		<div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
					<h5>Mensajes</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
