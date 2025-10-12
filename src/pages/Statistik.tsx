import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Users, Briefcase, GraduationCap, Home, TrendingUp } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const Statistik = () => {
  const demografiData = [
    { label: "Total Penduduk", value: "8.542", icon: Users, color: "text-blue-600" },
    { label: "Kepala Keluarga", value: "2.341", icon: Home, color: "text-green-600" },
    { label: "Laki-laki", value: "4.287", icon: Users, color: "text-purple-600" },
    { label: "Perempuan", value: "4.255", icon: Users, color: "text-pink-600" },
  ];

  const pendidikanData = [
    { tingkat: "Tidak/Belum Sekolah", jumlah: 856 },
    { tingkat: "SD/Sederajat", jumlah: 2341 },
    { tingkat: "SMP/Sederajat", jumlah: 1876 },
    { tingkat: "SMA/Sederajat", jumlah: 2145 },
    { tingkat: "Diploma/S1", jumlah: 987 },
    { tingkat: "S2/S3", jumlah: 337 },
  ];

  const pekerjaanData = [
    { jenis: "Petani", jumlah: 2134, persentase: 35 },
    { jenis: "Pedagang", jumlah: 1245, persentase: 20 },
    { jenis: "PNS/TNI/POLRI", jumlah: 734, persentase: 12 },
    { jenis: "Buruh", jumlah: 912, persentase: 15 },
    { jenis: "Wiraswasta", jumlah: 856, persentase: 14 },
    { jenis: "Lainnya", jumlah: 245, persentase: 4 },
  ];

  const kelompokUsia = [
    { rentang: "0-4 tahun", jumlah: 567 },
    { rentang: "5-14 tahun", jumlah: 1234 },
    { rentang: "15-24 tahun", jumlah: 1456 },
    { rentang: "25-54 tahun", jumlah: 3678 },
    { rentang: "55-64 tahun", jumlah: 945 },
    { rentang: "65+ tahun", jumlah: 662 },
  ];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Data Kependudukan
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Statistik Penduduk
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Data demografi dan statistik kependudukan Desa Digital
          </p>
        </div>
      </section>

      {/* Demografi Utama */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            {demografiData.map((item, index) => {
              const Icon = item.icon;
              return (
                <Card key={index} className="hover:shadow-lg transition-shadow">
                  <CardContent className="pt-6">
                    <div className="flex items-center justify-between mb-4">
                      <Icon className={`w-12 h-12 ${item.color}`} />
                      <TrendingUp className="w-6 h-6 text-muted-foreground" />
                    </div>
                    <p className="text-3xl font-bold mb-2">{item.value}</p>
                    <p className="text-sm text-muted-foreground">{item.label}</p>
                  </CardContent>
                </Card>
              );
            })}
          </div>

          {/* Kelompok Usia */}
          <Card className="mb-8">
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Users className="w-6 h-6 text-primary" />
                Distribusi Kelompok Usia
              </CardTitle>
              <CardDescription>Pembagian penduduk berdasarkan rentang usia</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {kelompokUsia.map((kelompok, index) => {
                  const maxJumlah = Math.max(...kelompokUsia.map(k => k.jumlah));
                  const width = (kelompok.jumlah / maxJumlah) * 100;
                  return (
                    <div key={index}>
                      <div className="flex items-center justify-between mb-2">
                        <span className="text-sm font-medium">{kelompok.rentang}</span>
                        <span className="text-sm text-muted-foreground">{kelompok.jumlah.toLocaleString('id-ID')} jiwa</span>
                      </div>
                      <div className="w-full bg-secondary rounded-full h-3">
                        <div 
                          className="bg-gradient-primary h-3 rounded-full transition-all duration-500"
                          style={{ width: `${width}%` }}
                        />
                      </div>
                    </div>
                  );
                })}
              </div>
            </CardContent>
          </Card>

          <div className="grid md:grid-cols-2 gap-8">
            {/* Pendidikan */}
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <GraduationCap className="w-6 h-6 text-primary" />
                  Tingkat Pendidikan
                </CardTitle>
                <CardDescription>Distribusi pendidikan penduduk</CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-4">
                  {pendidikanData.map((item, index) => (
                    <div key={index} className="flex items-center justify-between p-3 rounded-lg hover:bg-accent/50 transition-colors">
                      <span className="font-medium">{item.tingkat}</span>
                      <Badge variant="secondary">{item.jumlah.toLocaleString('id-ID')}</Badge>
                    </div>
                  ))}
                </div>
              </CardContent>
            </Card>

            {/* Mata Pencaharian */}
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center gap-2">
                  <Briefcase className="w-6 h-6 text-primary" />
                  Mata Pencaharian
                </CardTitle>
                <CardDescription>Distribusi pekerjaan penduduk</CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-4">
                  {pekerjaanData.map((item, index) => (
                    <div key={index}>
                      <div className="flex items-center justify-between mb-2">
                        <span className="font-medium">{item.jenis}</span>
                        <div className="flex items-center gap-2">
                          <span className="text-sm text-muted-foreground">{item.jumlah.toLocaleString('id-ID')}</span>
                          <Badge variant="outline">{item.persentase}%</Badge>
                        </div>
                      </div>
                      <div className="w-full bg-secondary rounded-full h-2.5">
                        <div 
                          className="bg-primary h-2.5 rounded-full transition-all duration-500"
                          style={{ width: `${item.persentase}%` }}
                        />
                      </div>
                    </div>
                  ))}
                </div>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Statistik;
