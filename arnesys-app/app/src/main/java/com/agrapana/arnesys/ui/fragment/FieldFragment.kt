package com.agrapana.arnesys.ui.fragment

import android.content.Intent
import android.content.SharedPreferences
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AlertDialog
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.ViewModelProvider
import androidx.recyclerview.widget.LinearLayoutManager
import com.agrapana.arnesys.R
import com.agrapana.arnesys.adapter.FieldAdapter
import com.agrapana.arnesys.adapter.FieldFilterAdapter
import com.agrapana.arnesys.databinding.FragmentFieldBinding
import com.agrapana.arnesys.ui.activity.LoginActivity
import com.agrapana.arnesys.ui.activity.SettingActivity
import com.agrapana.arnesys.viewmodel.FieldViewModel

class FieldFragment : Fragment() {

    private lateinit var binding: FragmentFieldBinding
    private lateinit var prefs: SharedPreferences
    private lateinit var recyclerViewAdapter: FieldAdapter
    private lateinit var viewModel: FieldViewModel

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentFieldBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        prefs = this.activity?.getSharedPreferences("prefs",
            AppCompatActivity.MODE_PRIVATE
        )!!

        initRecyclerView()
        initViewModel()

        binding.toolbar.inflateMenu(R.menu.action_nav2)
        binding.toolbar.setOnMenuItemClickListener {
            when(it.itemId) {
                R.id.about -> {
                    AlertDialog.Builder(requireContext())
                        .setTitle("App Version")
                        .setMessage("Beta 1.0.0")
                        .setCancelable(true)
                        .setPositiveButton("OK", null)
                        .create()
                        .show()
                }
                R.id.setting -> {
                    startActivity(Intent(context, SettingActivity::class.java))
                }
                R.id.logout -> {
                    val builder = AlertDialog.Builder(requireContext())
                    builder.setTitle("Are You Sure?")
                    builder.setMessage("You can't get in to your account")
                    builder.setPositiveButton("YES") { _, _ ->
                        val editor: SharedPreferences.Editor? = prefs.edit()
                        editor?.putBoolean("loginStart", true)
                        editor?.putString("client_id", null)
                        editor?.apply()
                        startActivity(Intent(activity, LoginActivity::class.java))
                    }
                    builder.setNegativeButton("NO") { dialog, _ ->
                        dialog.dismiss()
                    }
                    val alert = builder.create()
                    alert.show()
                }
            }
            true
        }

    }

    private fun initRecyclerView() {
        val linearLayoutManager = LinearLayoutManager(
            activity, LinearLayoutManager.VERTICAL, false
        )
        binding.recyclerView.layoutManager = linearLayoutManager
        recyclerViewAdapter = FieldAdapter(activity!!)
        binding.recyclerView.adapter = recyclerViewAdapter
        recyclerViewAdapter.notifyDataSetChanged()
    }

    private fun initViewModel() {
        val clientId: String? = prefs.getString("client_id", "")
        viewModel = ViewModelProvider(this)[FieldViewModel::class.java]
        viewModel.getAllField(clientId!!)
        viewModel.getLoadFieldObservable().observe(activity!!) {
            if(it?.data != null){
                Log.d("cek", it.data.toString())
                recyclerViewAdapter.setFieldList(it.data)
            }
        }
    }

}