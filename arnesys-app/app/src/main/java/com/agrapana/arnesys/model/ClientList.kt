package com.agrapana.arnesys.model

data class ClientList(val data: List<User>)
data class Client(val id: String?,val name: String?,  val email: String?, val status: String?, val gender: String?)
data class ClientResponse(val code: Int?, val meta: String?, val data: User?)