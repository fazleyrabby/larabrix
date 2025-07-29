<section class="overflow-hidden bg-gray-50 sm:grid sm:grid-cols-2 min-h-[150px]">
  <div class="p-4 md:p-12 lg:px-16 lg:py-24 flex items-center">
    <div class="mx-auto max-w-xl text-center ltr:sm:text-left rtl:sm:text-right">
      <h2 class="text-2xl font-bold text-gray-900 md:text-3xl">
        {{ $data['heading']['value'] ?? '' }}
      </h2>

      <p class="hidden text-gray-500 md:mt-4 md:block">
        {!!  $data['content']['value'] ?? '' !!}
      </p>
    </div>
  </div>

  <img
    alt=""
    src="{{ asset($data['image']['value'] ?? '') }}"
    class="w-full h-full object-cover"
  />
</section>
