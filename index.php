<?php 
session_set_cookie_params(3600*24*7);
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TCC - Avaliação de Filmes</title>
        <link href="style.css" rel="stylesheet">
        <link rel="shortcut icon" href="icone.png" type="image/x-png">
    </head>
    <body>
        <div class="semibody"><!-- Esta div está relacionada a tela e ajuda a ajustar as restantes -->
        
        <!-- Cabeçalho -->
        <?php include "header.php" ?> <!-- Cabeçalho da Página -->
        
        <!-- Conteúdo -->
        <div style="display: flex; justify-content: space-between; align-items: center; height: 100%;">
            <div class="content"><!-- Define o que estará no conteúdo central -->
                <div class="block"><!-- Cada div block é um bloco de conteúdo -->
                    <h1>Título de Exemplo</h1><br>
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sagittis nibh vel est rutrum, in euismod elit luctus. Nunc a nibh urna. Nulla quis velit a nulla vulputate tristique sed non justo. Donec ut risus eu orci rutrum ultrices nec nec sem. Praesent mauris augue, suscipit fermentum elit a, accumsan condimentum erat. Aenean eget est velit. Maecenas maximus mi eget mauris lacinia, et venenatis orci commodo. Suspendisse placerat quam vitae porttitor bibendum. Phasellus mattis leo quis quam imperdiet, sit amet suscipit lacus elementum. Sed nisl urna, sodales iaculis erat id, porta elementum erat. Quisque malesuada augue eu lorem finibus, at placerat risus porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum consectetur, nisi ac faucibus lobortis, ante mauris ornare arcu, a imperdiet leo arcu at ante. Aenean feugiat ipsum erat, a pretium lacus hendrerit quis. Quisque molestie libero eget nulla euismod, ac eleifend tortor semper. Sed euismod elit arcu, ut suscipit mauris eleifend pretium.
                    <br><br>
                    Sed nec quam iaculis, imperdiet sem sit amet, aliquet eros. Nunc et volutpat tortor. Quisque risus lorem, suscipit ac maximus in, feugiat aliquam est. Mauris non nisi quis dui finibus accumsan ac quis lectus. Nullam sed fringilla dolor. Aliquam consectetur leo ligula, et pharetra risus dictum non. Praesent auctor neque sed arcu feugiat dapibus. Donec nisl dolor, imperdiet vel enim egestas, laoreet laoreet arcu. Duis vulputate eget lacus vel sagittis. Curabitur arcu diam, tincidunt nec metus sit amet, scelerisque accumsan lectus. Integer interdum cursus tincidunt. Phasellus sollicitudin lobortis dolor, et iaculis elit eleifend nec. Curabitur massa velit, sollicitudin sed rutrum facilisis, dictum et elit. Vivamus pulvinar dapibus tellus ac faucibus. Pellentesque imperdiet interdum turpis at facilisis.
                    <br><br>
                    Nunc pulvinar tincidunt nisl nec finibus. Donec id eros blandit nunc efficitur posuere. Sed finibus neque sit amet quam egestas, vel suscipit purus pharetra. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin mi nulla, faucibus sit amet congue quis, placerat eu nisl. Aenean ornare id massa sed porta. In scelerisque lacus massa, at ultricies ligula tristique nec. Sed rhoncus nibh urna, in tincidunt velit scelerisque in.
                    </p>
                </div>
                <div class="block">
                    <h1>Lorem Ipsum</h1><br>
                    <p>
                    Sed dignissim in tellus sed commodo. Sed placerat, nunc sed vehicula pulvinar, sem diam auctor nisl, ut rhoncus odio urna vitae nulla. Vestibulum placerat id mauris id aliquet. Mauris malesuada malesuada viverra. Curabitur lacinia consequat fermentum. Sed fringilla tellus ante, ut consequat magna rhoncus sed. Nunc sollicitudin porttitor diam vel semper. Donec feugiat ex libero, pharetra posuere risus sagittis sed. Sed non purus nec mauris egestas posuere. Integer dapibus mauris at augue accumsan, a imperdiet lorem bibendum. Sed sapien purus, tristique sed dolor sed, fermentum euismod dui. Vestibulum rutrum malesuada odio id cursus. Nulla eu luctus enim. Sed nec nulla mi. Nunc vulputate tincidunt enim, at dignissim lectus luctus sit amet. Nam pulvinar orci tellus, et scelerisque ligula fringilla nec.
                    <br><br>
                    Sed lectus purus, maximus sed eros ut, rutrum aliquet justo. Praesent sagittis risus vitae turpis tincidunt lacinia. Aliquam tincidunt tristique ante. Duis felis nulla, vulputate a elit at, tristique hendrerit magna. Mauris leo augue, sagittis id nisi congue, convallis fringilla sem. Sed aliquam ante eget ligula hendrerit posuere. Nam maximus tortor vitae mauris condimentum condimentum. Cras quis magna orci. Suspendisse suscipit, tellus volutpat tincidunt convallis, tellus felis ornare tellus, eget hendrerit eros ex vitae nibh. Etiam euismod neque a justo ultrices, vel eleifend ex malesuada. Aenean ac rutrum leo, eu ullamcorper lorem. Nulla facilisi. Integer porttitor neque vitae finibus tincidunt. Morbi sed rhoncus mi, ut elementum augue. Quisque tristique, est non tristique egestas, massa massa eleifend elit, eu consequat elit tellus ut libero. In at faucibus neque.
                    <br><br>
                    Nunc pulvinar tincidunt nisl nec finibus. Donec id eros blandit nunc efficitur posuere. Sed finibus neque sit amet quam egestas, vel suscipit purus pharetra. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin mi nulla, faucibus sit amet congue quis, placerat eu nisl. Aenean ornare id massa sed porta. In scelerisque lacus massa, at ultricies ligula tristique nec. Sed rhoncus nibh urna, in tincidunt velit scelerisque in.
                    </p>
                </div>
                <div class="block">
                    <h1>Lectus Purus</h1><br>
                    <p>
                    Sed dignissim in tellus sed commodo. Sed placerat, nunc sed vehicula pulvinar, sem diam auctor nisl, ut rhoncus odio urna vitae nulla. Vestibulum placerat id mauris id aliquet. Mauris malesuada malesuada viverra. Curabitur lacinia consequat fermentum. Sed fringilla tellus ante, ut consequat magna rhoncus sed. Nunc sollicitudin porttitor diam vel semper. Donec feugiat ex libero, pharetra posuere risus sagittis sed. Sed non purus nec mauris egestas posuere. Integer dapibus mauris at augue accumsan, a imperdiet lorem bibendum. Sed sapien purus, tristique sed dolor sed, fermentum euismod dui. Vestibulum rutrum malesuada odio id cursus. Nulla eu luctus enim. Sed nec nulla mi. Nunc vulputate tincidunt enim, at dignissim lectus luctus sit amet. Nam pulvinar orci tellus, et scelerisque ligula fringilla nec.
                    <br><br>
                    Sed lectus purus, maximus sed eros ut, rutrum aliquet justo. Praesent sagittis risus vitae turpis tincidunt lacinia. Aliquam tincidunt tristique ante. Duis felis nulla, vulputate a elit at, tristique hendrerit magna. Mauris leo augue, sagittis id nisi congue, convallis fringilla sem. Sed aliquam ante eget ligula hendrerit posuere. Nam maximus tortor vitae mauris condimentum condimentum. Cras quis magna orci. Suspendisse suscipit, tellus volutpat tincidunt convallis, tellus felis ornare tellus, eget hendrerit eros ex vitae nibh. Etiam euismod neque a justo ultrices, vel eleifend ex malesuada. Aenean ac rutrum leo, eu ullamcorper lorem. Nulla facilisi. Integer porttitor neque vitae finibus tincidunt. Morbi sed rhoncus mi, ut elementum augue. Quisque tristique, est non tristique egestas, massa massa eleifend elit, eu consequat elit tellus ut libero. In at faucibus neque.
                    <br><br>
                    Nunc pulvinar tincidunt nisl nec finibus. Donec id eros blandit nunc efficitur posuere. Sed finibus neque sit amet quam egestas, vel suscipit purus pharetra. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin mi nulla, faucibus sit amet congue quis, placerat eu nisl. Aenean ornare id massa sed porta. In scelerisque lacus massa, at ultricies ligula tristique nec. Sed rhoncus nibh urna, in tincidunt velit scelerisque in.
                    </p>
                </div>
            </div>
        </div>
        <!-- Rodapé -->
        <?php include "footer.php" ?> <!-- Rodapé da Página -->
        
        </div>
    </body>
</html>
