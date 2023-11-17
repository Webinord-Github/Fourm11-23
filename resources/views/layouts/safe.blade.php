@verbatim
<main id="app-elementor">
    <div class="adminNav__container">
        <div class="adminNav">
            <div class="admin__logo">
                <img src="/files/logo-webinord-clair.png" alt="">
            </div>
            <div class="tabs">
                <p class="actif" data-tab="infos" @click="changeTab">Info</p>
                <p data-tab="blocs" @click="changeTab">Blocs</p>
            </div>
            <div id="infos" class="tab actif">
                <form name="elementor" action="#js" @submit.prevent=" createPost()" method="post" enctype="multipart/form-data">
                    <div>
                        @endverbatim
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        @verbatim
                        <input type="hidden" id="content" name="content">
                        <div>
                            <div>
                                <label for="title">Titre</label>
                                <input id="title" type="text" name="title" required autofocus />
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="slug">Lien</label>
                                <input id="slug"type="text" name="slug" required autofocus />
                            </div>
                        </div>
                        <div >
                            <div>
                                <label for="image">Image: jpeg, png, jpg, webp</label>
                                <input type="file" id="image" name="image">
                            </div>
                        </div>
                        <div>
                            <div>
                                <label value="Thématiques"></label>
                                <div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="status">Status</label>
                                <select name="status" id="status">
                                    <option value="brouillon">Brouillon</option>
                                    <option value="publié">Publié</option>
                                    <option value="archivé">Archivé</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="published_at">Date de publication</label>
                                <input id="published_at" type="datetime-local" name="published_at" required autofocus />
                            </div>
                        </div>
                        <div>
                            <a href="/admin/posts">Retour</a>
                            <input type="submit" value="Créer">
                        </div>
                    </div>
                </form>
            </div>
            <div id="blocs" class="tab">
                <div class="bloc">
                    <div class="x">
                        <i class="fa-solid fa-heading"></i>
                        <p>Titre</p>
                    </div>
                    <div class="y">
                        <div class="title-wrapper">
                            <h1>Titre</h1>
                        </div>
                    </div>
                </div>
                <div class="bloc">
                    <div class="x">
                        <i class="fa-solid fa-align-justify"></i>
                        <p>Texte</p>
                    </div>
                    <div class="y">
                        <div class="text-wrapper">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil possimus minus culpa omnis nostrum quas, quo numquam unde optio a? Quibusdam porro provident, voluptatum expedita ullam illum rem officia blanditiis!</p>
                        </div>
                    </div>
                </div>
                <div class="bloc">
                    <div class="x">
                        <i class="fa-solid fa-image"></i>
                        <p>Image</p>
                    </div>
                    <div class="y">
                        <div class="img-wrapper">
                            <img src="/storage/medias/6fabcd5159ebca87cafc17975f9e9667.jpeg">
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>

    <div class="elementor-container">
        <h1 class="title">Article builder</h1>
        <div id="preview">
        </div>
    </div>
</main>
@endverbatim