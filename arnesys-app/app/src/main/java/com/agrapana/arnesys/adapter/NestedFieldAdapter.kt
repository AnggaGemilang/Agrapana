package com.agrapana.arnesys.adapter

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat.startActivity
import androidx.recyclerview.widget.RecyclerView
import com.agrapana.arnesys.databinding.TemplateNestedFieldBinding
import com.agrapana.arnesys.ui.activity.DetailMainDeviceActivity
import com.agrapana.arnesys.ui.activity.DetailSupportDeviceActivity

class NestedFieldAdapter(val context: Context, private val fieldList: List<String>): RecyclerView.Adapter<NestedFieldAdapter.MyViewHolder>() {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): MyViewHolder {
        val inflater = LayoutInflater.from(parent.context)
        val binding = TemplateNestedFieldBinding.inflate(inflater, parent, false)
        return MyViewHolder(binding)
    }

    override fun getItemCount(): Int {
        return fieldList.size
    }

    override fun onBindViewHolder(holder: MyViewHolder, position: Int) {
        val deviceName: String = fieldList[position]
        holder.binding.nestedItemTv.text = deviceName

        val dateParts = deviceName.trim().split("\\s+".toRegex())
        holder.binding.cardView.setOnClickListener {

            if(dateParts[1] == "Utama"){
                context.startActivity(Intent(context, DetailMainDeviceActivity::class.java))
            } else {
                context.startActivity(Intent(context, DetailSupportDeviceActivity::class.java))
            }
        }
    }

    class MyViewHolder(val binding: TemplateNestedFieldBinding): RecyclerView.ViewHolder(binding.root){}

}
