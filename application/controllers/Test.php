<?php
/**
 * Created by PhpStorm.
 * User: Jair
 * Date: 12/4/2018
 */
class Test extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function codegen()
    {
//    	$codeGen = new CodeGenHandler('mat_material_status', 'material_status');
//    	$codeGen->generateModelFiles();
    }

	private function observations()
	{
		$projectList = "
		RA.17.1706	Con Nro. de orden	1/10/18	10/12/18
		RA.17.2320	Con Nro. de orden	1/10/18	8/11/18
		RA.17.2731	Con Nro. de orden	1/10/18	7/11/18
		RA.17.2849	Con Nro. de orden	1/10/18	18/10/2018
		RA.17.3105	Con Nro. de orden	1/10/18	8/10/18
		RA.17.3141	Con Nro. de orden	1/10/18	2/10/18
		RA.17.3146	Con Nro. de orden	1/10/18	16/10/2018
		RA.18.0060	Con Nro. de orden	1/10/18	3/10/18
		RA.18.0088	Con Nro. de orden	1/10/18	2/10/18
		RA.18.0120	Con Nro. de orden	1/10/18	18/10/2018
		RA.18.0152	Con Nro. de orden	1/10/18	11/9/19
		RA.18.0154	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.0174	Con Nro. de orden	1/10/18	2/10/18
		RA.18.0193	Con Nro. de orden	1/10/18	2/10/18
		RA.18.0217	Con Nro. de orden	1/10/18	28/02/2019
		RA.18.0240	Con Nro. de orden	1/10/18	2/10/18
		RA.18.0329	Con Nro. de orden	1/10/18	3/10/18
		RA.18.0483	Con Nro. de orden	1/10/18	3/10/18
		RA.18.0484	Con Nro. de orden	1/10/18	11/9/19
		RA.18.0485	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.0504	Con Nro. de orden	1/10/18	19/09/2019
		RA.18.0505	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.0506	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.0507	Con Nro. de orden	1/10/18	20/10/2018
		RA.18.0509	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.0511	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.0512	Con Nro. de orden	1/10/18	25/10/2018
		RA.18.0550	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.1218	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.1219	Con Nro. de orden	1/10/18	12/8/19
		RA.18.1422	Con Nro. de orden	1/10/18	11/9/19
		RA.18.1538	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.1539	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.1613	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.1615	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.1717	Con Nro. de orden	1/10/18	11/9/19
		RA.18.1795	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.1797	Con Nro. de orden	1/10/18	12/8/19
		RA.18.1912	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.1914	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.1946	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.2176	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.2190	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.2191	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.2297	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.2317	Con Nro. de orden	1/10/18	20/10/2018
		RA.18.2400	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.2447	Con Nro. de orden	1/10/18	12/8/19
		RA.18.2448	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.2449	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.2596	Con Nro. de orden	1/10/18	18/07/2019
		RA.18.2628	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.2894	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.2898	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.2899	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.2900	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.3052	Con Nro. de orden	1/10/18	27/03/2019
		RA.18.3096	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.3167	Con Nro. de orden	1/10/18	26/08/2019
		RA.18.3168	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0148	Con Nro. de orden	1/10/18	25/11/2019
		RA.19.0229	Con Nro. de orden	1/10/18	10/10/19
		RA.19.0236	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0283	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0370	Con Nro. de orden	1/10/18	14/05/2019
		RA.19.0371	Con Nro. de orden	1/10/18	13/05/2019
		RA.19.0466	Con Nro. de orden	28/08/2019	29/08/2019
		RA.19.0495	Con Nro. de orden	1/10/18	25/11/2019
		RA.19.0497	Con Nro. de orden	1/10/18	1/8/19
		RA.19.0500	Con Nro. de orden	1/10/18	10/10/19
		RA.19.0503	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0512	Con Nro. de orden	1/10/18	10/10/19
		RA.19.0546	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0554	Con Nro. de orden	1/10/18	1/8/19
		RA.19.0555	Con Nro. de orden	1/10/18	10/8/19
		RA.19.0558	Con Nro. de orden	1/10/18	1/8/19
		RA.19.0561	Con Nro. de orden	1/10/18	10/9/19
		RA.19.0570	Con Nro. de orden	1/10/18	11/9/19
		RA.19.0597	Con Nro. de orden	1/10/18	10/8/19
		RA.19.0608	Con Nro. de orden	1/10/18	8/11/19
		RA.19.0619	Con Nro. de orden	28/08/2019	29/08/2019
		RA.19.0620	Con Nro. de orden	28/08/2019	29/08/2019
		RA.19.0621	Con Nro. de orden	28/08/2019	29/08/2019
		RA.19.0622	Con Nro. de orden	28/08/2019	29/08/2019
		RA.19.0623	Con Nro. de orden	28/08/2019	29/08/2019
		RA.19.0628	Con Nro. de orden	1/10/18	29/08/2019
		RA.19.0649	Con Nro. de orden	1/10/18	4/6/19
		RA.19.0668	Con Nro. de orden	1/10/18	22/05/2019
		RA.19.0671	Con Nro. de orden	1/10/18	29/05/2019
		RA.19.0672	Con Nro. de orden	1/10/18	14/05/2019
		RA.19.0680	Con Nro. de orden	1/10/18	23/09/2019
		RA.19.0684	Con Nro. de orden	1/10/18	29/05/2019
		RA.19.0694	Con Nro. de orden	1/10/18	1/8/19
		RA.19.0695	Con Nro. de orden	1/10/18	11/9/19
		RA.19.0696	Con Nro. de orden	1/10/18	23/07/2019
		RA.19.0697	Con Nro. de orden	1/10/18	15/05/2019
		RA.19.0703	Con Nro. de orden	1/10/18	11/7/19
		RA.19.0717	Con Nro. de orden	1/10/18	10/8/19
		RA.19.0727	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0735	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0739	Con Nro. de orden	1/10/18	7/8/19
		RA.19.0745	Con Nro. de orden	1/10/18	15/05/2019
		RA.19.0746	Con Nro. de orden	1/10/18	4/6/19
		RA.19.0748	Con Nro. de orden	1/10/18	14/05/2019
		RA.19.0755	Con Nro. de orden	1/10/18	10/9/19
		RA.19.0779	Con Nro. de orden	1/10/18	19/06/2019
		RA.19.0787	Con Nro. de orden	1/10/18	24/06/2019
		RA.19.0795	Con Nro. de orden	1/10/18	24/05/2019
		RA.19.0797	Con Nro. de orden	1/10/18	19/09/2019
		RA.19.0805	Con Nro. de orden	1/10/18	23/09/2019
		RA.19.0806	Con Nro. de orden	1/10/18	4/6/19
		RA.19.0830	Con Nro. de orden	1/10/18	24/05/2019
		RA.19.0834	Con Nro. de orden	1/10/18	26/08/2019
		RA.19.0848	Con Nro. de orden	1/10/18	29/08/2019
		RA.19.0856	Con Nro. de orden	1/10/18	15/05/2019
		RA.19.0858	Con Nro. de orden	1/10/18	29/08/2019
		RA.19.0872	Con Nro. de orden	1/10/18	25/11/2019
		RA.19.0873	Con Nro. de orden	1/10/18	12/8/19
		RA.19.0876	Con Nro. de orden	1/10/18	10/9/19
		RA.19.0877	Con Nro. de orden	1/10/18	19/06/2019
		RA.19.0885	Con Nro. de orden	1/10/18	29/08/2019
		RA.19.0911	Con Nro. de orden	1/10/18	1/8/19
		RA.19.0916	Con Nro. de orden	1/10/18	19/09/2019
		RA.19.0920	Con Nro. de orden	1/10/18	13/12/2019
		RA.19.0921	Con Nro. de orden	1/10/18	23/09/2019
		RA.19.0954	Con Nro. de orden	1/10/18	23/09/2019
		RA.19.0956	Con Nro. de orden	1/10/18	10/9/19
		RA.19.0958	Con Nro. de orden	1/10/18	11/9/19
		RA.19.0962	Con Nro. de orden	1/10/18	12/8/19
		RA.19.0970	Con Nro. de orden	1/10/18	11/9/19
		RA.19.0994	Con Nro. de orden	1/10/18	10/10/19
		RA.19.1016	Con Nro. de orden	1/10/18	25/11/2019
		RA.19.1018	Con Nro. de orden	1/10/18	13/11/2019
		RA.19.1065	Con Nro. de orden	1/10/18	13/11/2019
		RA.19.1083	Con Nro. de orden	1/10/18	13/11/2019
		RA.19.1088	Con Nro. de orden	1/10/18	13/12/2019
		RA.19.1135	Con Nro. de orden	1/10/18	31/12/2019
		RA.19.1140	Con Nro. de orden	1/10/18	31/12/2019
		RA.19.1143	Con Nro. de orden	1/10/18	31/12/2019
		RA.19.1162	Con Nro. de orden	1/10/18	25/11/2019
		RA.19.1192	Con Nro. de orden	1/10/18	11/9/19
		RA.19.1203	Con Nro. de orden	1/10/18	23/09/2019
		RA.19.1211	Con Nro. de orden	1/10/18	20/08/2019
		RA.19.1218	Con Nro. de orden	1/10/18	29/08/2019
		RA.19.1251	Con Nro. de orden	1/10/18	13/12/2019
		RA.19.1259	Con Nro. de orden	1/10/18	16/11/2019
		RA.19.1319	Con Nro. de orden	1/10/18	29/08/2019
		RA.19.1321	Con Nro. de orden	1/10/18	23/09/2019
		RA.19.1335	Con Nro. de orden	1/10/18	13/12/2019
		RA.19.1428	Con Nro. de orden	1/10/18	23/09/2019
		RA.19.1489	Con Nro. de orden	1/10/18	13/12/2019
		RA.19.1495	Con Nro. de orden	1/10/18	31/12/2019
		RA.19.1504	Con Nro. de orden	1/10/18	13/09/2019
		RA.19.1537	Con Nro. de orden	1/10/18	13/09/2019
		RA.19.1542	Con Nro. de orden	1/10/18	25/11/2019
		RA.19.1618	Con Nro. de orden	1/10/18	31/12/2019
		RA.19.1620	Con Nro. de orden	1/10/18	31/12/2019
		RA.19.1648	Con Nro. de orden	1/10/18	13/12/2019
		RA.19.1826	Con Nro. de orden	30/12/2019	31/12/2019
		RD.16.0418	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0695	Con Nro. de orden	1/10/18	23/07/2019
		RD.16.0755	Con Nro. de orden	1/10/18	9/4/19
		RD.16.0757	Con Nro. de orden	1/10/18	9/4/19
		RD.16.0758	Con Nro. de orden	1/10/18	27/03/2019
		RD.16.0759	Con Nro. de orden	1/10/18	9/4/19
		RD.16.0760	Con Nro. de orden	1/10/18	31/12/2018
		RD.16.0821	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0822	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0824	Con Nro. de orden	1/10/18	24/12/2018
		RD.16.0830	Con Nro. de orden	1/10/18	15/10/2018
		RD.16.0831	Con Nro. de orden	1/10/18	26/12/2018
		RD.16.0846	Con Nro. de orden	1/10/18	9/9/19
		RD.16.0850	Con Nro. de orden	1/10/18	15/10/2018
		RD.16.0851	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0856	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0864	Con Nro. de orden	1/10/18	20/08/2019
		RD.16.0865	Con Nro. de orden	1/10/18	26/12/2018
		RD.16.0888	Con Nro. de orden	1/10/18	15/05/2019
		RD.16.0890	Con Nro. de orden	1/10/18	13/05/2019
		RD.16.0895	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0902	Con Nro. de orden	1/10/18	26/12/2018
		RD.16.0903	Con Nro. de orden	1/10/18	24/12/2018
		RD.16.0928	Con Nro. de orden	1/10/18	15/11/2018
		RD.16.0929	Con Nro. de orden	1/10/18	24/12/2018
		RD.16.0930	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0936	Con Nro. de orden	1/10/18	28/12/2018
		RD.16.0940	Con Nro. de orden	1/10/18	24/12/2018
		RD.16.0941	Con Nro. de orden	1/10/18	24/12/2018
		RD.16.0952	Con Nro. de orden	1/10/18	10/10/19
		RD.16.0970	Con Nro. de orden	1/10/18	8/12/18
		RD.16.0971	Con Nro. de orden	1/10/18	28/12/2018
		RD.17.0158	Con Nro. de orden	1/10/18	13/05/2019
		RD.17.0159	Con Nro. de orden	1/10/18	13/05/2019
		RD.17.0161	Con Nro. de orden	1/10/18	10/10/19
		RD.17.0167	Con Nro. de orden	1/10/18	13/05/2019
		RD.17.0170	Con Nro. de orden	1/10/18	25/11/2019
		RD.17.0176	Con Nro. de orden	1/10/18	16/11/2019
		RD.17.0177	Con Nro. de orden	1/10/18	13/05/2019
		RD.17.0178	Con Nro. de orden	1/10/18	13/05/2019
		RD.17.0196	Con Nro. de orden	1/10/18	25/11/2019
		RD.17.0197	Con Nro. de orden	1/10/18	25/11/2019
		RD.17.0199	Con Nro. de orden	1/10/18	11/9/19
		RD.17.0412	Con Nro. de orden	1/10/18	25/11/2019
		RD.17.0415	Con Nro. de orden	1/10/18	4/6/19
		RD.17.0416	Con Nro. de orden	1/10/18	4/6/19
		RD.17.0417	Con Nro. de orden	1/10/18	29/05/2019
		RD.17.0418	Con Nro. de orden	1/10/18	19/06/2019
		RD.17.0419	Con Nro. de orden	1/10/18	15/05/2019
		RD.17.0479	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0059	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0105	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0107	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0108	Con Nro. de orden	1/10/18	2/12/19
		RD.18.0109	Con Nro. de orden	1/10/18	27/12/2019
		RD.18.0110	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0111	Con Nro. de orden	1/10/18	27/12/2019
		RD.18.0164	Con Nro. de orden	1/10/18	8/4/19
		RD.18.0168	Con Nro. de orden	1/10/18	27/03/2019
		RD.18.0169	Con Nro. de orden	1/10/18	24/12/2018
		RD.18.0170	Con Nro. de orden	1/10/18	24/12/2018
		RD.18.0177	Con Nro. de orden	1/10/18	31/12/2019
		RD.18.0178	Con Nro. de orden	1/10/18	31/12/2019
		RD.18.0179	Con Nro. de orden	1/10/18	31/12/2019
		RD.18.0180	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0181	Con Nro. de orden	1/10/18	27/12/2019
		RD.18.0182	Con Nro. de orden	1/10/18	31/12/2019
		RD.18.0183	Con Nro. de orden	1/10/18	30/12/2019
		RD.18.0186	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0187	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0188	Con Nro. de orden	1/10/18	31/12/2019
		RD.18.0189	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0190	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0192	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0194	Con Nro. de orden	1/10/18	13/12/2019
		RD.18.0195	Con Nro. de orden	1/10/18	28/12/2018
		RD.18.0256	Con Nro. de orden	1/10/18	9/4/19
		RD.18.0270	Con Nro. de orden	1/10/18	28/12/2018
		RD.18.0271	Con Nro. de orden	1/10/18	31/12/2018
		RD.18.0272	Con Nro. de orden	1/10/18	11/9/19
		RD.18.0282	Con Nro. de orden	1/10/18	11/9/19
		RD.18.0283	Con Nro. de orden	1/10/18	27/03/2019
		RD.18.0286	Con Nro. de orden	1/10/18	27/03/2019
		RD.18.0293	Con Nro. de orden	1/10/18	27/03/2019
		RD.18.0294	Con Nro. de orden	1/10/18	26/08/2019
		RD.18.0303	Con Nro. de orden	1/10/18	9/4/19
		RD.18.0339	Con Nro. de orden	1/10/18	12/8/19
		RD.18.0395	Con Nro. de orden	1/10/18	17/12/2018
		RD.18.0401	Con Nro. de orden	1/10/18	31/12/2019
		RD.18.0504	Con Nro. de orden	1/10/18	25/11/2019
		RD.18.0505	Con Nro. de orden	1/10/18	4/6/19
		RD.19.0031	Con Nro. de orden	1/10/18	13/12/2019
		RD.19.0032	Con Nro. de orden	1/10/18	27/12/2019
		RD.19.0034	Con Nro. de orden	1/10/18	13/12/2019
		RD.19.0035	Con Nro. de orden	1/10/18	2/12/19
		RD.19.0036	Con Nro. de orden	1/10/18	30/12/2019
		RD.19.0037	Con Nro. de orden	1/10/18	27/12/2019
		RD.19.0038	Con Nro. de orden	1/10/18	13/12/2019
		RD.19.0039	Con Nro. de orden	1/10/18	2/12/19
		RD.19.0041	Con Nro. de orden	1/10/18	13/12/2019
		RD.19.0042	Con Nro. de orden	1/10/18	30/12/2019
		RD.19.0043	Con Nro. de orden	1/10/18	31/12/2019
		RD.19.0045	Con Nro. de orden	1/10/18	24/12/2019
		RD.19.0046	Con Nro. de orden	1/10/18	31/12/2019
		RD.19.0047	Con Nro. de orden	1/10/18	13/12/2019
		RD.19.0048	Con Nro. de orden	1/10/18	31/12/2019
		RD.19.0049	Con Nro. de orden	1/10/18	27/12/2019
		RD.19.0050	Con Nro. de orden	1/10/18	13/12/2019
		RD.19.0124	Con Nro. de orden	1/10/18	4/6/19
		RD.19.0149	Con Nro. de orden	1/10/18	25/11/2019
		RD.19.0186	Con Nro. de orden	1/10/18	25/11/2019
		RD.19.0246	Con Nro. de orden	1/10/18	31/12/2019
		RD.20.0216	Con Nro. de orden	1/10/18	27/12/2019
		RG.14.0016	Con Nro. de orden	1/10/18	10/10/19
		RG.18.0005	Con Nro. de orden	1/10/18	9/2/19
		RG.18.0011	Con Nro. de orden	1/10/18	25/10/2018
		RG.18.0075	Con Nro. de orden	1/10/18	2/10/18
		RG.18.0147	Con Nro. de orden	1/10/18	27/03/2019
		RG.19.0033	Con Nro. de orden	1/10/18	12/8/19
		RG.19.0038	Con Nro. de orden	1/10/18	31/12/2019
		RG.19.0189	Con Nro. de orden	1/10/18	31/12/2019
		RI.19.0048	Con Nro. de orden	1/10/18	13/12/2019
		RO.18.0014	Con Nro. de orden	1/10/18	23/10/2018
		RO.18.0033	Con Nro. de orden	1/10/18	23/10/2018
		RO.18.0105	Con Nro. de orden	1/10/18	28/09/2019
		RO.18.0124	Con Nro. de orden	1/10/18	10/12/18
		RO.18.0130	Con Nro. de orden	1/10/18	25/11/2018
		RO.18.0161	Con Nro. de orden	1/10/18	23/09/2019
		RO.18.0166	Con Nro. de orden	1/10/18	22/12/2018
		RO.18.0167	Con Nro. de orden	1/10/18	24/12/2018
		RO.18.0222	Con Nro. de orden	1/10/18	26/08/2019
		RO.18.0328	Con Nro. de orden	1/10/18	25/11/2019
		RO.18.0342	Con Nro. de orden	1/10/18	25/11/2019
		RO.19.0040	Con Nro. de orden	1/10/18	5/7/19
		RO.19.0129	Con Nro. de orden	1/10/18	29/08/2019
		RO.19.0134	Con Nro. de orden	1/10/18	5/7/19
		RO.19.0160	Con Nro. de orden	1/10/18	26/08/2019
		RO.19.0162	Con Nro. de orden	1/10/18	3/12/19
		RO.19.0168	Con Nro. de orden	1/10/18	13/12/2019
		RO.19.0172	Con Nro. de orden	1/10/18	10/10/19
		RO.19.0175	Con Nro. de orden	1/10/18	15/07/2019
		RO.19.0181	Con Nro. de orden	1/10/18	25/11/2019
		RV.19.0045	Con Nro. de orden	1/10/18	4/6/19
		RV.19.0047	Con Nro. de orden	1/10/18	10/10/19
		RV.19.0048	Con Nro. de orden	1/10/18	4/6/19
		RY.19.0013	Con Nro. de orden	1/10/18	26/08/2019
		SAC.18.0153	Con Nro. de orden	1/10/18	31/12/2018
		SAC.19.0105	Con Nro. de orden	1/10/18	12/8/19
		";
		$projectList = explode("\n",$projectList);
		$i = 0;
		$codeList = '';
		foreach ($projectList as $row)
		{
			if($i > 0 && $i < 308)
			{
				$row = trim($row);
				$row = explode("Con Nro. de orden", $row);
				$code = trim($row[0]);
				$codeList .= '"'.$code.'",';
			}
			$i++;
		}
		$codeList .= substr($codeList,0,-1);
		$sql = "
		SELECT
			* 
		FROM
			wfl_project_status_log
		left join wfl_projects on id_pro = project_id_psl and deleted_pro != 1
		WHERE
			status_id_psl = 45 
			-- AND manual_entry_date_psl BETWEEN '2018-10-01 00:00:00' 
			-- AND '2018-10-01 23:59:59'
			and deleted_psl != 1
			and code_pro in (".$codeList.")
		";
		echo"<pre>";var_dump($sql);exit;
	}

	public function warehouseSummary($projectId, $reservationNumber = NULL)
	{
		$parameters = array('project-id' => $projectId);
		if($reservationNumber != "")
		{
			$parameters = array('reservation-number' => $reservationNumber,'project-id' => $projectId);
		}
		$parameters['grouping-criteria'] = ' project_id_msu, material_id_prm ';
		$materialPaginationHandler = new MaterialSummaryPaginationHandler(1000,0,'material_description');
		$materialPaginationHandler->setAdditionalParameters($parameters);
		echo json_encode($materialPaginationHandler->getAll());exit;
	}
}
