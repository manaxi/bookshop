<a href="{{ route('dashboard.books.edit',$id) }}" data-toggle="tooltip" data-original-title="Edit"
   class="edit btn btn-success edit">
    Edit
</a>
<form action="{{ route('dashboard.books.delete', $id) }}" method="POST" onsubmit="return confirm('Are your sure?');"
      style="display: inline-block;">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="submit" class="btn btn-xs btn-danger" value="yes">
</form>
