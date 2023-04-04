<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/home.css">
    <title>Home | Gad.get</title>
  </head>

  <body>
    @guest

    <header>
      <a href="" class="logo">Gad.get</a>

      <a href="{{ route('login') }}" class="button">Login</a>
    </header>

    @else
    
    <header>
      @if ($user)
        <h2>Hello, {{ $user->name }}</h2>
    
        <a href="{{ route('logout') }}" class="nav-link active" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();" >Log Out</a>
      @endif
    </header>
    
    @endguest
    <form action="{{ route('logout') }}" id="logout-form" method="POST">
      @csrf
    </form>
    
    <section class="products">
      <div class="container">
        <div class="products">
          <h1 class="heading">Latest <span>Products</span></h1>
          <div class="box-container" style="grid-template-columns: repeat(auto-fit, minmax(370px, auto)); gap: 2rem; align-items: center; margin-bottom: 100px; margin-top: 3rem;">
              @foreach ($products as $item)
              <form class="box" action="{{url("/home/$item->id")}}"  method="POST">
                @csrf
                  <img src="img/{{ $item->image }}" alt="" style="width: 245px; height: 178px; padding-right: 15px;">
                  <h2 class="name">{{ $item->name }}</h2>
                  <h3 class="price">Rp {{ $item->price }}/-</h3>
                  <input type="number" min="1" name="quantity" value="1">
                  <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                </form>
              @endforeach
          </div>
        </div>
      </div>
    </section>
    
    <section class="cart">
      <div class="shopping-cart">
        <h1 class="heading">Shopping Cart</h1>
        @if (session()->has('success'))
          <div class="alert alert-success">
            {{ session()->get('success') }}
          </div>
        @endif
        <form action="{{ url('/home', $item) }}" method="POST">
          <table>
            <thead>
              <th>Image</th>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total Price</th>
              <th>Action</th>
            </thead>
            <tbody>
              @if (isset($cartItem))
                @foreach ($cartItem as $item)
                  <tr>
                    <td><img src="{{ 'img/' . $item->product->image }}" height="100" alt=""></td>
                    <td>{{ $item->product->name }}</td>
                    <td>Rp {{ $item->product->price }}-</td>
                    <td>
                      <form action="{{ url('/home', $item) }}" method="POST">
                        @csrf 
                        @method('PATCH')
                        {{-- <input type="hidden" name="cart_id" value="{{ $item->id }}"> --}}
                        <input type="number" min="1" name="quantity" value="{{ $item->quantity }}" style="background-color: #ECF2FF; padding: 5px; border: none; border-radius: 5px; width: 60px;">
                        <input type="submit" name="update_cart" value="update" class="option-btn" style="color: white; background-color: #4481eb; border: none; padding: 5px; border-radius: 5px;">
                                          
                    </td>
                    <td>Rp {{ $item->product->price * $item->quantity }} /-</td>
                    <td>
                      <form action="{{ url('/home', $item) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" name="delete" value="delete" class="option-btn" style="color: white; background-color: #eb444c; border: none; padding: 5px; border-radius: 5px;">
                      </form>
                    </td> 
                  </tr>
                @endforeach
              @endif
              <tr>
                <td colspan="4" style="text-align:right">Grand Total:</td>
                <td>Rp {{ $grandTotal }} /-</td>
              </tr>
            </tbody>
          </table>
        </form>
         </div>
    </section>


    <footer>
        <p>Copyright © 2023 Gad.get corp. All Rights Reserved.</p>
    </footer>

  </body>
</html>