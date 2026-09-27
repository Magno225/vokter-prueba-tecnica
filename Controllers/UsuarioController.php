<?php
require_once __DIR__ . '/../Models/usuarioServer.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct($db) {
        $this->usuarioModel = new Usuario($db);
    }

    public function registrar($cedula, $nombre, $apellido, $correo, $password, $telefono) {
        if ($this->usuarioModel->obtenerPorCorreo($correo)) {
            return ['exito' => false, 'mensaje' => 'Ese correo ya está registrado.'];
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $creado = $this->usuarioModel->crear($cedula, $nombre, $apellido, $correo, $hash, $telefono);

        if ($creado) {
            return ['exito' => true, 'mensaje' => 'Cuenta creada correctamente.'];
        }
        return ['exito' => false, 'mensaje' => 'Ocurrió un error al crear la cuenta.'];
    }

    public function login($correo, $password) {
        $usuario = $this->usuarioModel->obtenerPorCorreo($correo);

        if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
            return ['exito' => false, 'mensaje' => 'Correo o contraseña incorrectos.'];
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];

        return ['exito' => true];
    }

    public function obtenerDatos($id) {
    return $this->usuarioModel->obtenerPorId($id);
}

public function actualizarPerfil($id, $nombre, $apellido, $correo, $telefono) {
    $usuarioConEseCorreo = $this->usuarioModel->obtenerPorCorreo($correo);
    if ($usuarioConEseCorreo && $usuarioConEseCorreo['id'] != $id) {
        return ['exito' => false, 'mensaje' => 'Ese correo ya está en uso por otra cuenta.'];
    }

    $actualizado = $this->usuarioModel->actualizarDatos($id, $nombre, $apellido, $correo, $telefono);

    if ($actualizado) {
        return ['exito' => true, 'mensaje' => 'Datos actualizados correctamente.'];
    }
    return ['exito' => false, 'mensaje' => 'Ocurrió un error al actualizar tus datos.'];
}

public function cambiarPassword($id, $passwordActual, $passwordNueva) {
    $usuario = $this->usuarioModel->obtenerPorId($id);

    if (!$usuario || !password_verify($passwordActual, $usuario['password_hash'])) {
        return ['exito' => false, 'mensaje' => 'La contraseña actual no es correcta.'];
    }

    $hash = password_hash($passwordNueva, PASSWORD_DEFAULT);
    $actualizado = $this->usuarioModel->actualizarPassword($id, $hash);

    if ($actualizado) {
        return ['exito' => true, 'mensaje' => 'Contraseña actualizada correctamente.'];
    }
    return ['exito' => false, 'mensaje' => 'Ocurrió un error al cambiar la contraseña.'];
}

}