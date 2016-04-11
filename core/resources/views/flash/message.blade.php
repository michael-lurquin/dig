<div class="container">
    <!-- <div class="row">
        <div class="col-md-10 col-md-offset-1"> -->

            <?php
            $types = [
                'success' => 'success',
                'error' => 'danger',
                'warning' => 'warning',
                'info' => 'info'
            ];
            ?>

            @foreach($types as $type => $bootstrap)

                @if (Session::has($type))
                    @include('flash.alert', ['message' => Session::get($type), 'type' => $bootstrap])
                @endif

            @endforeach
        <!-- </div>
    </div> -->
</div>
