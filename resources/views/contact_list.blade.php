@extends("template.main")
@section('title', 'Contact List')
@section('body')
<div class="row d-flex justify-content-center m-5">
  <div class="col-xl-8">
    <h2 class="pb-4">Contact List</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Message</th>
          <th>Action</th> <!-- Tambah kolom untuk tombol delete -->
        </tr>
      </thead>
      <tbody>
        @foreach($contacts as $contact)
        <tr>
          <td>{{ isset($contact->name) ? $contact->name : '' }}</td>
          <td>{{ isset($contact->email) ? $contact->email : '' }}</td>
          <td>{{ isset($contact->phone) ? $contact->phone : '' }}</td>
          <td>{{ isset($contact->message) ? $contact->message : '' }}</td>
          <td>
            <form method="POST" action="{{ route('delete_contact', $contact->id ?? 'default') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
