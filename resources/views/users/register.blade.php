<x-layout>
    <form action="/users" method="post" class="mt-10">
        @csrf

        <label>Name</label>
        <input type="text" value="{{old('name')}}" name="name" class="border"  />
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
        <br><br>

        <label>Email</label>
        <input type="email" value="{{old('email')}}" name="email" class="border"  />
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

        <button type="submit" class="bg-cyan-200 p-2">Cadastrar</button>
    </form>
</x-layout>