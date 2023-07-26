package com.agrapana.arnesys.ui.fragment

import android.graphics.Color
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import com.agrapana.arnesys.R
import com.agrapana.arnesys.databinding.FragmentMainDeviceChartBinding
import com.agrapana.arnesys.viewmodel.DetailMainDeviceViewModel
import com.github.mikephil.charting.data.Entry
import com.github.mikephil.charting.data.LineData
import com.github.mikephil.charting.data.LineDataSet
import com.github.mikephil.charting.utils.ColorTemplate
import java.util.ArrayList

class MainDeviceChartFragment(
    private val id: String,
    private val column: String,
    ) : Fragment() {

    private lateinit var binding: FragmentMainDeviceChartBinding
    private lateinit var viewModel: DetailMainDeviceViewModel
    private var type: String = "latest"

    lateinit var lineList: ArrayList<Entry>
    private lateinit var lineDataSet: LineDataSet
    lateinit var lineData: LineData

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentMainDeviceChartBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.columnName.text = column

        initViewModel()

    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this)[DetailMainDeviceViewModel::class.java]
        viewModel.getChartMainDevice(id, column, type)
        viewModel.getLoadChartObservable().observe(activity!!) {
            if(it?.data != null){
                Log.d("dadang_main", it.data.toString())

                lineList = ArrayList()
                lineList.add(Entry(10f, 1f))
                lineList.add(Entry(12f, 2f))
                lineList.add(Entry(15f, 3f))
                lineList.add(Entry(20f, 4f))

                lineDataSet = LineDataSet(lineList, "histories of $column")
                lineData = LineData(lineDataSet)
                binding.chart.data = lineData
                lineDataSet.setColors(*ColorTemplate.PASTEL_COLORS)
                lineDataSet.valueTextColor = Color.BLACK
                lineDataSet.valueTextSize = 14f
                lineDataSet.setDrawFilled(false)
                lineDataSet.fillDrawable = ContextCompat.getDrawable(activity!!, R.drawable.gradient_chart)
            }
        }
    }

}