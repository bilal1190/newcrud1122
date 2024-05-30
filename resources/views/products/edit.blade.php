<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Crud Operation 1122</title>
  </head>
  <body>
    <div class="bg-dark py-3">
          <h3 class="text-white text-center">Crud Operation 1122</h3>
    </div>
        <div class="container">
          <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('products.index')}}" class="btn btn-dark">Back</a>
            </div>
        </div>
        <div class="row d-flexs justify-content-center">
            <div class="col-md-10">
                <div class="card borde-0 shadow-lg my-4">
                    <div class="card-header bg-dark text-white ">
                        <h3>Edit Product</h3>
                    </div>
                     <form  action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
                        @method('put')
                       @csrf
                         <div class="card-body">
                           <div class="mb-3">
                            <label for="" class="form-label h5">Name</label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name',$product->name) }}">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>    
                            @enderror
                          </div>
                        <div class="mb-3">
                            <label for="" class="form-label h5">Sku</label>
                            <input type="text" class="form-control form-control-lg @error('sku') is-invalid @enderror" placeholder="323292" name="sku" value="{{ old('sku',$product->sku) }}">
                            @error('sku')
                            <div class="text-danger">{{ $message }}</div>    
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label h5">Price</label>
                            <input type="text" class="form-control form-control-lg  @error('price') is-invalid @enderror"  placeholder="Price" name="price"  value="{{ old('price',$product->price) }}">
                            @error('price')
                            <div class="text-danger">{{ $message }}</div>    
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label h5">Description</label>
                            <textarea class="form-control" placeholder="Enter Description" name="description"  cols="30" rows="10">{{ old('description',$product->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label h5">Image</label>
                            <input type="file" class="form-control form-control-lg" placeholder="image" name="image">
                            @if ($product->image != "")
                                    <img class="w-50 my-2" src="{{ asset('uploads/products/'
                                    .$product->image)}}" alt="">
                            @endif
                        </div>
                        <div class="text-center row-span-1">
                            <button class="btn btn-primary">Update</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </form>

  </body>
</html>