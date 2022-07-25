package com.example.nialonic_gc.adapter

import android.annotation.SuppressLint
import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.ImageView
import android.widget.TextView
import androidx.cardview.widget.CardView
import androidx.recyclerview.widget.RecyclerView
import com.example.nialonic_gc.R
import com.example.nialonic_gc.databinding.ItemPresetsBinding
import com.example.nialonic_gc.model.Preset

@SuppressLint("NotifyDataSetChanged")
class PresetsAdapter(taskListener: TaskListener) : RecyclerView.Adapter<PresetsAdapter.MyViewHolder>() {

    private var presets = mutableListOf<Preset>()
    private var taskListener: TaskListener = taskListener

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): PresetsAdapter.MyViewHolder {
        val inflater = LayoutInflater.from(parent.context).inflate(R.layout.item_presets, parent, false)
        return MyViewHolder(inflater)
    }

    override fun getItemCount() = presets.size

    override fun onBindViewHolder(holder: MyViewHolder, position: Int) {
        holder.tvName.text = presets[position].plantName
        holder.tvgasValve.text = "CO2 Valve : " + presets[position].gasValve
        holder.tvNutrition.text = "Nutrition : " + presets[position].nutrition
        holder.tvGrowthLamp.text = "Growth Lamp : " + presets[position].growthLamp
        holder.tvSeedlingTime.text = "Seedling Time : " + presets[position].seedlingTime
        holder.tvGrowTime.text = "Grow Time : " + presets[position].growTime
        holder.tvTemperature.text = "Temperature : " + presets[position].temperature
        holder.tvPump.text = "Pump : " + presets[position].pump

        holder.optionMenu.setOnClickListener {
            taskListener.onOptionClick(it, presets[position])
        }
    }

    fun setPresets(presets: List<Preset>) {
        this.presets = presets as MutableList<Preset>
        notifyDataSetChanged()
    }

    fun addPreset(author: Preset) {
        if (!presets.contains(author)){
            presets.add(author)
        } else {
            val index = presets.indexOf(author)
        }
        notifyDataSetChanged()
    }

    class MyViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        var tvName: TextView
        var tvgasValve: TextView
        var tvNutrition: TextView
        var tvGrowthLamp: TextView
        var tvSeedlingTime: TextView
        var tvGrowTime: TextView
        var tvTemperature: TextView
        var tvPump: TextView
        var optionMenu: ImageButton

        init {
            tvName = view.findViewById(R.id.tv_name)
            tvgasValve = view.findViewById(R.id.tv_gas_valve)
            tvNutrition = view.findViewById(R.id.tv_nutrition)
            tvGrowthLamp = view.findViewById(R.id.tv_growth_lamp)
            tvSeedlingTime = view.findViewById(R.id.tv_seedling_time)
            tvGrowTime = view.findViewById(R.id.tv_grow_time)
            tvTemperature = view.findViewById(R.id.tv_temperature)
            tvPump = view.findViewById(R.id.tv_pump)
            optionMenu = view.findViewById(R.id.option_menu)
        }
    }

    interface TaskListener {
        fun onOptionClick(view: View, preset: Preset)
    }
}