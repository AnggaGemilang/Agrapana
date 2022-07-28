package com.example.nialonic_gc.adapter

import android.annotation.SuppressLint
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageButton
import android.widget.ImageView
import android.widget.LinearLayout
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.nialonic_gc.R
import com.example.nialonic_gc.model.Plant
import com.example.nialonic_gc.model.Preset
import com.example.nialonic_gc.ui.fragment.SeekPlantFragment

@SuppressLint("NotifyDataSetChanged")
class PlantsAdapter(taskListener: PlantsAdapter.TaskListener) : RecyclerView.Adapter<PlantsAdapter.MyViewHolder>() {

    private var plants = mutableListOf<Plant>()
    private var taskListener: PlantsAdapter.TaskListener = taskListener

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): PlantsAdapter.MyViewHolder {
        val inflater = LayoutInflater.from(parent.context).inflate(R.layout.item_plants, parent, false)
        return MyViewHolder(inflater)
    }

    override fun getItemCount() = plants.size

    override fun onBindViewHolder(holder: MyViewHolder, position: Int) {
        holder.tvName.text = plants[position].name
        holder.tvStatus.text = plants[position].status
        holder.tvMode.text = plants[position].mode + " mode"
        holder.tvEndPlant.text = plants[position].plantEnded
        Glide.with(holder.imageView.context)
            .load(plants[position].imgUrl)
            .into(holder.imageView);
        holder.wrapper.setOnClickListener {
            taskListener.onDetailClick(it, plants[position])
        }
    }

    fun setPlants(plants: List<Plant>) {
        this.plants = plants as MutableList<Plant>
        notifyDataSetChanged()
    }

    fun addPlants(plant: Plant) {
        if (!plants.contains(plant)){
            plants.add(plant)
        } else {
            val index = plants.indexOf(plant)
        }
        notifyDataSetChanged()
    }

    class MyViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        var tvName: TextView
        var tvStatus: TextView
        var tvEndPlant: TextView
        var tvMode: TextView
        var imageView: ImageView
        var wrapper: LinearLayout

        init {
            tvName = view.findViewById(R.id.tv_name)
            tvStatus = view.findViewById(R.id.tv_status)
            tvEndPlant = view.findViewById(R.id.tv_end)
            tvMode = view.findViewById(R.id.tv_mode)
            imageView = view.findViewById(R.id.thumbnail)
            wrapper = view.findViewById(R.id.wrapper)
        }
    }

    interface TaskListener {
        fun onDetailClick(view: View, plant: Plant)
    }

}