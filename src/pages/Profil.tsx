import { Badge } from "@/components/ui/badge";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { MapPin, Target, Eye, Users, Briefcase } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";

const Profil = () => {
  const visiMisi = {
    visi: "Mewujudkan Desa Maju Sejahtera yang mandiri, berbudaya, dan berkelanjutan dengan meningkatkan kesejahteraan masyarakat melalui pemberdayaan ekonomi dan pelayanan publik yang berkualitas.",
    misi: [
      "Meningkatkan kualitas pelayanan publik yang cepat, transparan, dan akuntabel",
      "Mengembangkan potensi ekonomi lokal melalui pemberdayaan UMKM dan pertanian",
      "Meningkatkan kualitas pendidikan dan kesehatan masyarakat",
      "Melestarikan budaya dan kearifan lokal",
      "Membangun infrastruktur desa yang merata dan berkelanjutan",
    ],
  };

  const strukturOrganisasi = [
    { jabatan: "Kepala Desa", nama: "Bapak Suharto, S.Sos" },
    { jabatan: "Sekretaris Desa", nama: "Ibu Sri Wahyuni, S.AP" },
    { jabatan: "Kaur Keuangan", nama: "Bapak Ahmad Yani" },
    { jabatan: "Kaur Perencanaan", nama: "Ibu Dewi Sartika, S.T" },
    { jabatan: "Kasi Pemerintahan", nama: "Bapak Sukarno" },
    { jabatan: "Kasi Kesejahteraan", nama: "Ibu Kartini, S.Sos" },
  ];

  const demografi = [
    { label: "Jumlah Penduduk", value: "3.245 Jiwa" },
    { label: "Jumlah KK", value: "892 KK" },
    { label: "Laki-laki", value: "1.654 Jiwa" },
    { label: "Perempuan", value: "1.591 Jiwa" },
    { label: "Luas Wilayah", value: "12,5 km²" },
    { label: "Jumlah Dusun", value: "4 Dusun" },
  ];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Profil Desa
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Desa Maju Sejahtera
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Mengenal lebih dekat profil dan informasi lengkap tentang Desa Maju Sejahtera
          </p>
        </div>
      </section>

      {/* Sejarah */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto">
            <div className="flex items-center mb-6">
              <MapPin className="w-6 h-6 text-primary mr-3" />
              <h2 className="text-3xl font-bold text-foreground">Sejarah Desa</h2>
            </div>
            <div className="prose prose-lg max-w-none text-muted-foreground">
              <p className="mb-4">
                Desa Maju Sejahtera didirikan pada tahun 1945, bersamaan dengan kemerdekaan Indonesia. 
                Nama "Maju Sejahtera" dipilih sebagai harapan dan cita-cita para pendiri desa agar 
                masyarakat dapat terus maju dan sejahtera dari generasi ke generasi.
              </p>
              <p className="mb-4">
                Awalnya, desa ini merupakan perkampungan kecil dengan mata pencaharian utama di bidang 
                pertanian. Seiring berjalannya waktu, desa berkembang menjadi sentra pertanian dan UMKM 
                yang produktif dengan berbagai inovasi dan pemberdayaan masyarakat.
              </p>
              <p>
                Hingga saat ini, Desa Maju Sejahtera terus berkembang dengan tetap mempertahankan 
                nilai-nilai budaya dan kearifan lokal, sambil mengadopsi teknologi modern untuk 
                meningkatkan pelayanan kepada masyarakat.
              </p>
            </div>
          </div>
        </div>
      </section>

      <Separator className="my-8" />

      {/* Visi Misi */}
      <section className="py-16 bg-accent/20">
        <div className="container mx-auto px-4">
          <div className="max-w-5xl mx-auto">
            <div className="grid md:grid-cols-2 gap-8">
              {/* Visi */}
              <Card className="hover:shadow-lg transition-shadow">
                <CardHeader>
                  <div className="flex items-center mb-2">
                    <Eye className="w-6 h-6 text-primary mr-3" />
                    <CardTitle className="text-2xl">Visi</CardTitle>
                  </div>
                </CardHeader>
                <CardContent>
                  <p className="text-muted-foreground leading-relaxed">{visiMisi.visi}</p>
                </CardContent>
              </Card>

              {/* Misi */}
              <Card className="hover:shadow-lg transition-shadow">
                <CardHeader>
                  <div className="flex items-center mb-2">
                    <Target className="w-6 h-6 text-primary mr-3" />
                    <CardTitle className="text-2xl">Misi</CardTitle>
                  </div>
                </CardHeader>
                <CardContent>
                  <ol className="list-decimal list-inside space-y-3 text-muted-foreground">
                    {visiMisi.misi.map((item, index) => (
                      <li key={index} className="leading-relaxed">{item}</li>
                    ))}
                  </ol>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </section>

      {/* Demografi */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="flex items-center justify-center mb-4">
              <Users className="w-6 h-6 text-primary mr-3" />
              <h2 className="text-3xl font-bold text-foreground">Data Demografi</h2>
            </div>
          </div>
          
          <div className="max-w-4xl mx-auto">
            <div className="grid grid-cols-2 md:grid-cols-3 gap-6">
              {demografi.map((item, index) => (
                <Card key={index} className="text-center hover:shadow-lg transition-shadow">
                  <CardContent className="pt-6">
                    <h3 className="text-2xl font-bold text-primary mb-2">{item.value}</h3>
                    <p className="text-muted-foreground text-sm">{item.label}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Struktur Organisasi */}
      <section className="py-16 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="flex items-center justify-center mb-4">
              <Briefcase className="w-6 h-6 text-primary mr-3" />
              <h2 className="text-3xl font-bold text-foreground">Struktur Organisasi</h2>
            </div>
            <p className="text-muted-foreground">Perangkat Desa Maju Sejahtera</p>
          </div>
          
          <div className="max-w-4xl mx-auto">
            <div className="grid md:grid-cols-2 gap-4">
              {strukturOrganisasi.map((item, index) => (
                <Card key={index} className="hover:shadow-lg transition-shadow">
                  <CardContent className="p-6">
                    <h3 className="font-bold text-lg text-foreground mb-1">{item.jabatan}</h3>
                    <p className="text-muted-foreground">{item.nama}</p>
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

export default Profil;
