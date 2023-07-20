package com.agrapana.arnesys.model

data class FieldList(val data: List<Field>)
data class Field(
    val id: String?,
    val address: String?,
    val plant_type: String?,
    val thumbnail: String?,
    val number_of_support_device: Int?,
    val client_id: String?,
    val created_at: String?,
    val updated_at: String?,
    var isExpandable: Boolean = false,
)
data class Links(
    val url: String?,
    val label: String?,
    val active: Boolean?
)
data class FieldResponse(
    val current_page: Int?,
    val data: List<Field>?,
    val first_page_url: String?,
    val from: Int?,
    val last_page: Int?,
    val last_page_url: String?,
    val links: List<Links>?,
    val next_page_url: String?,
    val path: String?,
    val per_page: Int?,
    val prev_page_url: String?,
    val to: Int?,
    val total: Int?
)