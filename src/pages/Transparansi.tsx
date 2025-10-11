import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { DollarSign, TrendingUp, TrendingDown, PieChart, FileText, Download } from "lucide-react";
import { Button } from "@/components/ui/button";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const Transparansi = () => {
  const apbdesData = {
    tahun: "2024",
    totalPendapatan: "Rp 1.250.000.000",
    totalBelanja: "Rp 1.150.000.000",
    surplus: "Rp 100.000.000",
  };

  const pendapatan = [
    { sumber: "Dana Desa (DD)", jumlah: "Rp 750.000.000", persentase: "60%" },
    { sumber: "Alokasi Dana Desa (ADD)", jumlah: "Rp 300.000.000", persentase: "24%" },
    { sumber: "Bagi Hasil Pajak & Retribusi", jumlah: "Rp 150.000.000", persentase: "12%" },
    { sumber: "Pendapatan Asli Desa", jumlah: "Rp 50.000.000", persentase: "4%" },
  ];

  const belanja = [
    {
      bidang: "Penyelenggaraan Pemerintahan Desa",
      jumlah: "Rp 400.000.000",
      persentase: "34.8%",
      keterangan: "Operasional pemerintahan, gaji perangkat",
    },
    {
      bidang: "Pembangunan Desa",
      jumlah: "Rp 450.000.000",
      persentase: "39.1%",
      keterangan: "Infrastruktur jalan, irigasi, fasilitas umum",
    },
    {
      bidang: "Pembinaan Kemasyarakatan",
      jumlah: "Rp 150.000.000",
      persentase: "13%",
      keterangan: "Kegiatan sosial, budaya, olahraga",
    },
    {
      bidang: "Pemberdayaan Masyarakat",
      jumlah: "Rp 100.000.000",
      persentase: "8.7%",
      keterangan: "UMKM, pertanian, pelatihan warga",
    },
    {
      bidang: "Penanggulangan Bencana",
      jumlah: "Rp 50.000.000",
      persentase: "4.4%",
      keterangan: "Dana darurat dan tanggap bencana",
    },
  ];

  const programPrioritas = [
    {
      nama: "Pembangunan Jalan Desa",
      anggaran: "Rp 250.000.000",
      realisasi: "75%",
      status: "Sedang Berjalan",
    },
    {
      nama: "Pengembangan UMKM",
      anggaran: "Rp 100.000.000",
      realisasi: "85%",
      status: "Sedang Berjalan",
    },
    {
      nama: "Perbaikan Irigasi",
      anggaran: "Rp 150.000.000",
      realisasi: "100%",
      status: "Selesai",
    },
    {
      nama: "Posyandu & Kesehatan",
      anggaran: "Rp 75.000.000",
      realisasi: "90%",
      status: "Sedang Berjalan",
    },
  ];

  const laporanKeuangan = [
    { periode: "Semester 1 2024", file: "Laporan-Semester-1-2024.pdf" },
    { periode: "Tahun 2023", file: "Laporan-Tahunan-2023.pdf" },
    { periode: "Semester 2 2023", file: "Laporan-Semester-2-2023.pdf" },
    { periode: "Semester 1 2023", file: "Laporan-Semester-1-2023.pdf" },
  ];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            APBDes
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Transparansi Keuangan Desa
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Informasi terbuka mengenai pengelolaan keuangan dan anggaran desa
          </p>
        </div>
      </section>

      {/* Overview */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-foreground mb-2">
              APBDes Tahun {apbdesData.tahun}
            </h2>
            <p className="text-muted-foreground">Ringkasan Anggaran Pendapatan dan Belanja Desa</p>
          </div>

          <div className="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            <Card className="text-center hover:shadow-lg transition-shadow border-primary/20">
              <CardContent className="pt-6">
                <div className="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                  <TrendingUp className="w-8 h-8 text-primary" />
                </div>
                <h3 className="text-sm font-medium text-muted-foreground mb-2">Total Pendapatan</h3>
                <p className="text-3xl font-bold text-primary">{apbdesData.totalPendapatan}</p>
              </CardContent>
            </Card>

            <Card className="text-center hover:shadow-lg transition-shadow border-secondary/20">
              <CardContent className="pt-6">
                <div className="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                  <TrendingDown className="w-8 h-8 text-secondary" />
                </div>
                <h3 className="text-sm font-medium text-muted-foreground mb-2">Total Belanja</h3>
                <p className="text-3xl font-bold text-secondary">{apbdesData.totalBelanja}</p>
              </CardContent>
            </Card>

            <Card className="text-center hover:shadow-lg transition-shadow border-green-500/20">
              <CardContent className="pt-6">
                <div className="w-16 h-16 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                  <DollarSign className="w-8 h-8 text-green-600" />
                </div>
                <h3 className="text-sm font-medium text-muted-foreground mb-2">Surplus</h3>
                <p className="text-3xl font-bold text-green-600">{apbdesData.surplus}</p>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      <Separator className="my-8" />

      {/* Pendapatan */}
      <section className="py-16 bg-accent/20">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            <div className="flex items-center mb-8">
              <TrendingUp className="w-6 h-6 text-primary mr-3" />
              <h2 className="text-3xl font-bold text-foreground">Sumber Pendapatan Desa</h2>
            </div>

            <div className="grid md:grid-cols-2 gap-4">
              {pendapatan.map((item, index) => (
                <Card key={index} className="hover:shadow-lg transition-shadow">
                  <CardContent className="p-6">
                    <div className="flex justify-between items-start mb-2">
                      <h3 className="font-semibold text-foreground">{item.sumber}</h3>
                      <Badge variant="outline">{item.persentase}</Badge>
                    </div>
                    <p className="text-2xl font-bold text-primary">{item.jumlah}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Belanja */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            <div className="flex items-center mb-8">
              <PieChart className="w-6 h-6 text-secondary mr-3" />
              <h2 className="text-3xl font-bold text-foreground">Alokasi Belanja Desa</h2>
            </div>

            <div className="space-y-4">
              {belanja.map((item, index) => (
                <Card key={index} className="hover:shadow-lg transition-shadow">
                  <CardHeader>
                    <div className="flex justify-between items-start">
                      <div className="flex-1">
                        <CardTitle className="text-lg">{item.bidang}</CardTitle>
                        <CardDescription>{item.keterangan}</CardDescription>
                      </div>
                      <Badge variant="secondary" className="ml-4">{item.persentase}</Badge>
                    </div>
                  </CardHeader>
                  <CardContent>
                    <p className="text-2xl font-bold text-secondary">{item.jumlah}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Program Prioritas */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="text-3xl font-bold text-foreground mb-2">
                Program Prioritas Desa
              </h2>
              <p className="text-muted-foreground">Realisasi program pembangunan tahun berjalan</p>
            </div>

            <div className="grid md:grid-cols-2 gap-6">
              {programPrioritas.map((program, index) => (
                <Card key={index} className="hover:shadow-lg transition-shadow">
                  <CardHeader>
                    <CardTitle className="text-lg">{program.nama}</CardTitle>
                    <CardDescription>Anggaran: {program.anggaran}</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <div className="space-y-3">
                      <div>
                        <div className="flex justify-between text-sm mb-2">
                          <span className="text-muted-foreground">Realisasi</span>
                          <span className="font-semibold text-primary">{program.realisasi}</span>
                        </div>
                        <div className="w-full bg-muted rounded-full h-2.5">
                          <div 
                            className="bg-primary h-2.5 rounded-full transition-all"
                            style={{ width: program.realisasi }}
                          ></div>
                        </div>
                      </div>
                      <Badge 
                        variant={program.status === "Selesai" ? "default" : "secondary"}
                        className="w-full justify-center"
                      >
                        {program.status}
                      </Badge>
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Laporan Keuangan */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto">
            <div className="flex items-center mb-8">
              <FileText className="w-6 h-6 text-primary mr-3" />
              <h2 className="text-3xl font-bold text-foreground">Laporan Keuangan</h2>
            </div>

            <div className="grid md:grid-cols-2 gap-4">
              {laporanKeuangan.map((laporan, index) => (
                <Card key={index} className="hover:shadow-lg transition-shadow">
                  <CardContent className="p-6 flex items-center justify-between">
                    <div className="flex items-center space-x-4">
                      <div className="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                        <FileText className="w-6 h-6 text-primary" />
                      </div>
                      <div>
                        <h3 className="font-semibold text-foreground">{laporan.periode}</h3>
                        <p className="text-sm text-muted-foreground">{laporan.file}</p>
                      </div>
                    </div>
                    <Button size="sm" variant="outline">
                      <Download className="w-4 h-4 mr-2" />
                      Unduh
                    </Button>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Transparansi;
