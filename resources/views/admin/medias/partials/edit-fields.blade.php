{!! csrf_field() !!}



<div class="px-12 pb-8 flex flex-col items-center w-10/12">
@if (!$errors->isEmpty())
<div role="alert" class="w-full pb-8">
  <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
    Empty Fields
  </div>
  <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
    @foreach ($errors->all() as $message)
        <ul class="px-4">
            <li class="list-disc">{{$message}}</li>
        </ul>
    @endforeach
  </div>
</div>
@endif
    <div class="w-full mb-2">
        <table class="w-full">
            <tbody class="flex">
                <tr class="flex flex-col w-2/12">
                    <td class="font-bold">Uploaded:</td>
                    <td class="font-bold">By:</td>
                    <td class="font-bold">File Url:</td>
                    <td class="font-bold">File Name:</td>
                    <td class="font-bold">File Type:</td>
                    <td class="font-bold">File Size:</td>
                </tr>
                <tr class="align-start flex flex-col">
                    <td>{{$model->created_at}}</td>
                    <td>{{$user->name}}</td>
                    <td><a href="/files/{{$model->url}}" style="color:blue;text-decoration:underline;" target="_blank"><?= url("file/$model->url") ?></td>
                    <td>{{$model->url}}</td>
                    <td>{{$model->provider}}</td>
                    <?php 
                        if($model->file_size > 999) {
                            $new_file_size = $model->file_size / 1024;
                            $new_file_size_formatted = number_format((float)$new_file_size, 2, '.', '');
                            ?>
                            <td><?= $new_file_size_formatted ?> Mb</td> 
                            <?php
                        } 
                        if($model->file_size < 1000){
                            ?>
                            <td>{{$model->file_size}} Kb</td> 
                        <?php } ?>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="w-full mb-2 flex">
        <img width="300px" src="/storage/media/{{$model->url}}" alt="">
    </div>
  
    <div class="w-full mb-2">
        <div class="flex justify-center flex-col"> 
            <label for="description">Alternative text</label>  
            <input type='text' class="w-8/12 border rounded py-2 text-gray-700 focus:outline-none" name="description" id="description" value="{{ $model->description }}">
        </div>
    </div>
    <div class="w-full flex justify-start">
        <input type="submit" class="w-60 mt-6 py-2 rounded bg-blue-500 hover:bg-blue-700 text-gray-100 focus:outline-none font-bold cursor-pointer" value="Edit">
    </div>
</div>


