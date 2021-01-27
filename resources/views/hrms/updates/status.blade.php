<div class="row">
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    @if(Auth::user()->employee->photo)
                        <img src="{{\Auth::user()->employee->photo}}" width="80px"
                             height="80px">
                        <br/>
                        <div class="small-help-block"> {{\Auth::user()->name}}</div>
                    @else
                        <img src="{{ URL::asset('assets/img/avatars/profile_pic.png') }}" width="80px"
                             height="80px">
                        <br/>
                        <div class="small-help-block"> {{\Auth::user()->name}}</div>
                    @endif
                </div>
                <div class="col-md-10">
                    <strong>{{$post->status}}</strong>
                    <div class="small-help-block">{{formatDate($post->created_at)}}</div>
                </div>
            </div>
            <hr/>
            @foreach($post->replies as $reply)
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{getUserData($reply->user_id)['employee']['photo']}}" width="80px"
                             height="80px">
                    </div>
                    <div class="col-md-6">
                        {{$reply->message}}
                        <div class="small-help-block">{{formatDate($reply->created_at)}}</div>
                    </div>
                </div>
                <hr/>
        @endforeach
        <!-- reply box -->
            <div class="section">
                <label class="field prepend-icon">
                           <textarea class="gui-textarea" id="comment" rows="6"
                                     placeholder="Type your reply in 360 letters"
                                     style="padding-left:100px; height:130px" maxlength="360"
                                     name="comment"></textarea>
                    <label for="comment" class="field-icon">
                        <img src="http://alliance-html.themerex.net/assets/img/avatars/profile_avatar.jpg"
                             width="80px" height="80px"
                             style="padding-top: 10px; padding-left: 4px">
                        <div style="padding-left:560px">
                            <input type="submit" class="btn btn-success" value="Reply">
                        </div>
                    </label>
                </label>
                <div id="loader-{{$post->id}}">
                    <img src="{{ URL::asset('img/loader.gif') }}">
                </div>
            </div>
            <!-- /reply box -->
        </div>
    </div>
</div>