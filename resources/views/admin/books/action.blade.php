<a href="{{ route('admin.books.edit',$id) }}" data-toggle="tooltip" data-original-title="Edit"
   class="edit btn btn-success edit">
    Edit
</a>
<form action="{{ route('admin.books.destroy', $id) }}" method="POST" onsubmit="return confirm('Are your sure?');"
      style="display: inline-block;">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="submit" class="btn  btn-danger" value="Delete">
</form>
