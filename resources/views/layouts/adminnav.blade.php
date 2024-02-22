<div class="admin__nav__container">
    <div class="user__container">
        <p>{{auth()->user()->firstname}}</p>
        <img src="{{auth()->user()->profilePicture->path . auth()->user()->profilePicture->name}}" alt="">
    </div>

  
</div>
