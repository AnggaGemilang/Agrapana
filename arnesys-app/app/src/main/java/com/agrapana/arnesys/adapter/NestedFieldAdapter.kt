package com.agrapana.arnesys.adapter

import android.view.LayoutInflater
import android.view.ViewGroup
import android.widget.Toast
import androidx.recyclerview.widget.RecyclerView
import com.agrapana.arnesys.databinding.TemplateNestedFieldBinding


class NestedFieldAdapter(private val fieldList: List<String>): RecyclerView.Adapter<NestedFieldAdapter.MyViewHolder>() {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): MyViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        val binding = TemplateNestedFieldBinding.inflate(inflater, parent, false)
        return MyViewHolder(binding)
    }

    override fun getItemCount(): Int {
        return fieldList.size
    }

    override fun onBindViewHolder(holder: MyViewHolder, position: Int) {
        holder.binding.nestedItemTv.text = fieldList[position]

        holder.binding.cardView.setOnClickListener {

        }
    }

    class MyViewHolder(val binding: TemplateNestedFieldBinding): RecyclerView.ViewHolder(binding.root){}

}
