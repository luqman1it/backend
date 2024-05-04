<!DOCTYPE html>
<html lang="en">
<head>
   @include("Backend.Dashboard.layouts.header")
</head>
<body>
    <div>
@include("Backend.Dashboard.layouts.sidebar")
    </div>
    <div>
        @include("Backend.Dashboard.layouts.nav")
            </div>
            {{-- منحط المحتوى لي رح يتغير متل الفورم  --}}
            @yield('content')

            @include("Backend.Dashboard.layouts.footer")
</body>
</html>
