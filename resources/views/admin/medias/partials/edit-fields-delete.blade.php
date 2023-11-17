<div class="px-12 pb-8 flex flex-col items-center w-10/12">
    <div class="w-full flex justify-start">
        @csrf
        {{method_field('DELETE')}}
        <input type="submit" value="Delete file" class="hover:bg-gray-200 my-5 dropdownHover cursor-pointer text-left text-red-500" onclick="return confirm('Are you sure to delete?')"> 
    </div>
</div>