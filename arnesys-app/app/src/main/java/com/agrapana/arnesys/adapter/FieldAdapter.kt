package com.agrapana.arnesys.adapter

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.agrapana.arnesys.R
import com.agrapana.arnesys.databinding.TemplateFieldBinding
import com.agrapana.arnesys.model.Field


class FieldAdapter(val context: Context): RecyclerView.Adapter<FieldAdapter.MyViewHolder>() {

    var fieldList = mutableListOf<Field>()

    fun setFieldList(fields: List<Field>): Boolean {
        this.fieldList = fields.toMutableList()
        notifyDataSetChanged()
        return true
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): MyViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        val binding = TemplateFieldBinding.inflate(inflater, parent, false)
        return MyViewHolder(binding)
    }

    override fun getItemCount(): Int {
        return fieldList.size
    }

    override fun onBindViewHolder(holder: MyViewHolder, position: Int) {

        var nestedList: MutableList<String> = ArrayList()
        val model: Field = fieldList[position]
        holder.binding.itemTv.text = model.plant_type

        val isExpandable = model.isExpandable
        holder.binding.expandableLayout.visibility = if (isExpandable) View.VISIBLE else View.GONE

        if (isExpandable) {
            holder.binding.arroImageview.setImageResource(R.drawable.baseline_arrow_upward_24)
        } else {
            holder.binding.arroImageview.setImageResource(R.drawable.baseline_arrow_downward_24)
        }

        nestedList.add("Perangkat Utama")
        for (i in 1..model.number_of_support_device!!){
            nestedList.add("Perangkat Pendukung $i")
        }

        val adapter = NestedFieldAdapter(nestedList)
        holder.binding.childRv.layoutManager = LinearLayoutManager(holder.itemView.context)
        holder.binding.childRv.setHasFixedSize(true)
        holder.binding.childRv.adapter = adapter
        holder.binding.linearLayout.setOnClickListener(View.OnClickListener {
            model.isExpandable = !model.isExpandable
            notifyItemChanged(holder.adapterPosition)
        })
    }

    class MyViewHolder(val binding: TemplateFieldBinding): RecyclerView.ViewHolder(binding.root){}

}
