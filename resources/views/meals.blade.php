<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Jela svijeta</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <div>
                <form class="needs-validation" novalidate action="{{route('filter')}}" method="get">
                    @csrf
                    <div class="mb-3">
                        <label for="filter">Jezici</label>
                        <select class="custom-select d-block w-100" name="language" id="language" required>
                          <option value="" disabled selected>Odaberite jezik / Language / Lingua</option>
                          <option value="it">IT</option>
                          <option value="en">EN</option>
                          <option value="hr">HR</option>
                        </select>
                        <div class="invalid-feedback">
                          Molimo Vas, odaberite jezik.
                        </div>
                      </div>
                    <div class="mb-3">
                        <label for="filter">Tagovi / Tags / Tags</label>
                        <input type="text" name="tags" value="" class="form-control" id="tag" placeholder="tag1,tag2,tag3...">
                    </div>
                    <div class="mb-3">
                        <label for="filter">Kategorije / Categories / Categorie</label>
                        <input type="text" name="categories" value="" class="form-control" id="category" placeholder="Cat1,Cat2,Cat3...">
                    </div>
                    <div class="mb-3">
                        <label for="filter">Br. rezultata po stranici / Pagination / Nr. per pagina</label>
                        <input type="text" name="pagination" value="10" class="form-control" id="pagination" placeholder="10">
                    </div>
                    <div class="mb-3">
                        <label for="filter">Sastojci / Ingredients / Ingredienti</label>
                        <input type="text" name="ingredients" value="" class="form-control" id="ingredient" placeholder="Ing1,Ing2,Ing3...">
                    </div>
                    <div class="mb-3">
                        <label for="filter">Vrijeme / Time and Date / Data</label>
                        <input type="text" name="unix_timestamp" value="" class="form-control" id="unix_timestamp" placeholder="1647929302">
                    </div>
                    <div class="mb-3">
                        <label for="filter"></label>
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Primijeni</button>
                    </div>
                </form>
            </div>



            <table class="table table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">ID</th>
                        @if ($language == 'it')
                            <th scope="col">Piatto</th>
                            <th scope="col">Descrizione</th>
                        @elseif ($language == 'en')
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                        @else
                            <th scope="col">Naziv</th>
                            <th scope="col">Opis</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($meals as $meal)
                    <tr>
                        <th scope="row">{{ $meal->id }}</th>
                        <th scope="row">{{ $meal->title }}</th>
                        <th scope="row">{{ $meal->description }}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {!! $meals->appends($next_query)->links() !!}
            </div>
        </div>
    </body>
</html>
