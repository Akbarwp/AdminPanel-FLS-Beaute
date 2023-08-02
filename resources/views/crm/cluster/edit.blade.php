@extends('templates/main')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="container justify text-left">
    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label class="text" style="color:black">Cluster</label>
            </div>
            <div class="col-10">
                <div class="textview">
                <p>A</p>
                </div>
                
            </div>
            
        </div>
        <div class="row">
            <div class="col-2">
                <label for="exampleInputAddress" class="text" style="color:black">Discount</label>
            </div>
            <div class="col-10">
                <input type="address" class="form-control" id="exampleInputAddress"
                    placeholder="Masukkan Discount">
            </div>
            
        </div>
    </div>
    <div class="form-group text-right">
<input type="submit" onclick="location.href='{{ url('/crm/cluster/') }}'" class="btn btn-primary submit" style="background-color:rgba(165,78,182); color:whitesmoke" value="Edit">
</div>
</div>
@endsection

@section('script')
<script>
</script>
@endsection