@push('head')
    <link href="{{ asset('css/comp-config.css') }}?v={{ time() }}" rel="stylesheet">
    <script src="{{ asset('js/tools/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/comp-config.js') }}"></script>
@endpush



<section class="config-section">

    <div class="bloco">
        <button id="btnMenus" onclick="modalMenu()" class="menus" ativo><i class="fas fa-bars"></i>Menus</button>
        <button id="btnMinhaConta" onclick="modalConta()" class="minhaConta"><i class="fas fa-user-cog"></i></i>Minha
            Conta</button>
    </div>


    <div class="div-padding">
        <table width="100%" id="table">
            <button class="add-new" id="add-new" onclick="addNewMenu()">Adicionar Novo</button>
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Link</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($menus as $menu)
                    <div id="menus-aberto" class="menus-aberto">
                        <tr>
                            <td>
                                <a>
                                    <div class="title">
                                        <span>{{ $menu->titulo }}</span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <div class="link">
                                        <span>{{ $menu->slog }}</span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a>
                                    <div class="status">
                                        <span>
                                            @if ($menu->status == 1)
                                                Ativado
                                            @else
                                                Desativado
                                            @endif
                                        </span>
                                        <div class="btn-edit">
                                            <button onclick="editMenu({{ $menu->id }})"
                                                class="edit">Editar</button>
                                            <button onclick="deleteMenu({{ $menu->id }})"
                                                class="btn-delete-menu">Excluir</button>
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                    </div>
                @endforeach
            </tbody>
        </table>

        <div class="conta" style="display: none">
            minha conta
        </div>

        <div class="novo-menu" style="display: none">
            <form class="new-title-menu form" id="new-title-menu">
                <div class="div-titulo">
                    <label>Título do Menu</label>
                    <input type="text" name="titulo" id="titulo">
                </div>

                <div class="div-conteudo">
                    <label>Conteúdo do Menu</label>
                    <textarea rows="8" cols="50" id="conteudo-pagina" name="conteudo-pagina" class="conteudo-pagina"></textarea>
                </div>

                <div class="div-url">
                    <label>URL da Página</label>
                    <input type="text" name="link" id="link">
                </div>

                <div class="container-save">
                    <div class="onOf">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            <option value="Ativado">Ativado</option>
                            <option value="Desativado">Desativado</option>
                        </select>
                        <input type="hidden" name="id_admin" id="id_dmin" value="{{ $admin->id }}">
                    </div>
                    <div class="btn">
                        <button type="submit" class="save"><i class="far fa-save"></i>Salvar</button>
                        <button class="cancel"><i class="fal fa-times-circle"></i>Cancelar</button>
                    </div>
                </div>

            </form>
        </div>
    </div>


    </div>


</section>
