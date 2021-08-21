

<div class="row">
<div class="col-lg-12 col-xl-6">
        <div class="table-responsive">
            <table class="table m-0">
                <tbody>
                    <tr>
                        <th scope="row">First name</th>
                        <td>{{Auth::user()->first_name}}</td>
                        <!-- <td><i class="fa fa-eye"></i></td> -->
                    </tr>

                    <tr>
                        <th scope="row">Username</th>
                        <td>@if(Auth::user()->username)
                            {{Auth::user()->username}}
                            @endif
                        </td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>


                    <tr>
                        <th scope="row">Contact number</th>
                        <td>@if(Auth::user()->mobile)
                            {{Auth::user()->mobile}}
                            @else
                            <a href="javascript:;" class="editDetails" style="text-decoration: underline;">Add contact number</a>
                            @endif
                        </td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                    <tr>
                        <th scope="row">Postal address</th>
                        <td>@if(Auth::user()->address)
                            {{Auth::user()->address}}
                            @else
                                <a href="javascript:;" class="editDetails" style="text-decoration: underline;">Add address</a>
                            @endif
                        </td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end of table col-lg-6 -->
    <div class="col-lg-12 col-xl-6">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">Last name</th>
                        <td>{{Auth::user()->last_name ? Auth::user()->last_name : '' }}</td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>{{Auth::user()->email}}</td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                    <tr>
                        <th scope="row">Website</th>
                        <td><a target="_blank" href="{{Auth::user()->profile->website}}"></a>
                            @if(Auth::user()->profile->website)
                            {{Auth::user()->profile->website}}
                            @else
                                <a href="javascript:;" class="editDetails" style="text-decoration: underline;">Add website</a>
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-12 text-right">
        <button type="button" id="editDetails" class="editDetails btn btn-sm waves-effect waves-light">
        <i class="fa fa-pencil"></i>
        </button>
        </div>
</div>

