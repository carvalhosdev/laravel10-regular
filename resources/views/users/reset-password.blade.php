<x-layout>
       <p>Verify Your Email Address</p>
       <form action="/reset-password" method="POST">
       @csrf
            <input type="text" name="token" value="{{$token}}" class='w-full border'>
            <br>
            <label>Email</label>
            <input type="email" value="{{$email}}" name="email" class="border"  />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            <br><br>
            <label for="">Senha</label>
            <input type="password" value="{{old('password')}}" name="password" class="border" />
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            <br><br>
            <label for="">Confirmar Senha</label>
            <input type="password" value="{{old('password_confirmation')}}" name="password_confirmation" class="border" />
            @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            <br><br>

        <button type="submit" class="bg-cyan-200 p-2">Recuperar</button>

       </form>
</x-layout>