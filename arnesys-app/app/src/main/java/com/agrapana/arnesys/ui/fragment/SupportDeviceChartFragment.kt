package com.agrapana.arnesys.ui.fragment

import android.graphics.Color
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.AdapterView
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.lifecycle.ViewModelProvider
import com.agrapana.arnesys.R
import com.agrapana.arnesys.databinding.FragmentSupportDeviceChartBinding
import com.agrapana.arnesys.viewmodel.DetailSupportDeviceViewModel
import com.github.mikephil.charting.data.Entry
import com.github.mikephil.charting.data.LineData
import com.github.mikephil.charting.data.LineDataSet
import com.github.mikephil.charting.utils.ColorTemplate
import java.util.ArrayList

class SupportDeviceChartFragment(
    private val id: String,
    private val number: Int,
    private val column: String,
) : Fragment() {

    private lateinit var binding: FragmentSupportDeviceChartBinding
    private lateinit var viewModel: DetailSupportDeviceViewModel
    private var type: String = "latest"

    lateinit var lineList: ArrayList<Entry>
    private lateinit var lineDataSet: LineDataSet
    lateinit var lineData: LineData

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View {
        binding = FragmentSupportDeviceChartBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        binding.columnName.text = column

        initViewModel()

        binding.spinner.onItemSelectedListener = object : AdapterView.OnItemSelectedListener{
            override fun onNothingSelected(parent: AdapterView<*>?) {
                //
            }
            override fun onItemSelected(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
                type = parent?.getItemAtPosition(position).toString().lowercase()
                getChartData()
            }
        }
    }

    private fun initViewModel() {
        viewModel = ViewModelProvider(this)[DetailSupportDeviceViewModel::class.java]
    }

    private fun getChartData(){

        lateinit var columnDB: String

        when(column) {
            "Warmth" -> {
                columnDB = "soil_temperature"
            }
            "Moisture" -> {
                columnDB = "soil_humidity"
            }
            "pH" -> {
                columnDB = "soil_ph"
            }
            "Nitrogen" -> {
                columnDB = "soil_nitrogen"
            }
            "Phosphor" -> {
                columnDB = "soil_phosphor"
            }
            "Kalium" -> {
                columnDB = "soil_kalium"
            }
        }

        viewModel.getChartSupportDevice(id, number, columnDB, type)
        viewModel.getLoadChartObservable().observe(activity!!) {
            Log.d("dadang_support", it?.data.toString())

            if(it?.data != null){
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