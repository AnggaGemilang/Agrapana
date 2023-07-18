package com.agrapana.arnesys.model

data class Auth(val email: String?, val password: String?)
data class AuthResponse(val code: Int?, val meta: String?, val data: Auth?)