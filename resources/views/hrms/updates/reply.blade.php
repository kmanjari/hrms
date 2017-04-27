<div class="row">
    <div class="col-md-2">
        <img src="{{getUserData($reply->user_id)['employee']['photo']}}"
             width="80px"
             height="80px">
        <div class="small-help-block"> {{getUserData($reply->user_id)['name']}}</div>
    </div>
    <div class="col-md-6">
        {{$reply->message}}
        <div class="small-help-block">{{formatDate($reply->created_at)}}</div>
    </div>
</div>
<hr />