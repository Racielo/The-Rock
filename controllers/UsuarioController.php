require_once "models/Usuario.php";

class UsuarioController {
    public function index(){
        $modelo = new Usuario();
        $usuarios = $modelo->obtenerUsuarios();

        require_once "views/usuarios.php";
    }
}