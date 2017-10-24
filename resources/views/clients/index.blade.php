@extends('layouts.app')

@section('content')
	
	<div class="container spaced-container">
		
		<a class="btn btn-success" href="/clients/create"><i class="fa fa-plus"></i> Nieuw</a>

		<table class="table my-table table-striped table-hover">
			<thead>
				<tr>
					<th class="th5p">ID</th>
					<th class="th15p">Naam</th>
					<th class="th45p">URL</th>
					<th class="th20p">Eigenaar</th>
					<th class="th15p">Acties</th>
				</tr>
			</thead>
			<tbody>
				@foreach($clients as $client)
					<tr>
						<td>{{ $client->id }}</td>
						<td>{{ $client->name }}</td>
						<td>{{ $client->redirect }}</td>
						<td>{{ $client->user_id }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-secondary" href="/clients/{{ $client->id }}"><i class="fa fa-eye"></i></a>
								<a class="btn btn-danger" href="/clients/{{ $client->id }}/delete"><i class="fa fa-trash"></i></a>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@endsection