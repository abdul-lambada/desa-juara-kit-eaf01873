import { Badge } from "@/components/ui/badge";
import { Card } from "@/components/ui/card";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import gallery1 from "@/assets/gallery-1.jpg";
import gallery2 from "@/assets/gallery-2.jpg";
import gallery3 from "@/assets/gallery-3.jpg";

const Galeri = () => {
  const galleryItems = [
    {
      id: 1,
      image: gallery1,
      title: "Musyawarah Desa",
      category: "Pemerintahan",
      description: "Rapat koordinasi perangkat desa membahas program kerja tahun 2024",
    },
    {
      id: 2,
      image: gallery2,
      title: "Gotong Royong Pertanian",
      category: "Pertanian",
      description: "Kegiatan gotong royong masyarakat dalam masa tanam padi",
    },
    {
      id: 3,
      image: gallery3,
      title: "Perayaan Tradisional",
      category: "Budaya",
      description: "Festival budaya desa menampilkan kesenian dan tradisi lokal",
    },
    {
      id: 4,
      image: gallery1,
      title: "Pembinaan UMKM",
      category: "Ekonomi",
      description: "Pelatihan kewirausahaan untuk pelaku UMKM desa",
    },
    {
      id: 5,
      image: gallery2,
      title: "Posyandu Balita",
      category: "Kesehatan",
      description: "Pelayanan kesehatan rutin untuk balita dan ibu hamil",
    },
    {
      id: 6,
      image: gallery3,
      title: "HUT RI ke-78",
      category: "Acara",
      description: "Perayaan kemerdekaan dengan berbagai lomba dan pertunjukan",
    },
    {
      id: 7,
      image: gallery1,
      title: "Kerja Bakti Desa",
      category: "Lingkungan",
      description: "Kegiatan bersih-bersih lingkungan desa oleh warga",
    },
    {
      id: 8,
      image: gallery2,
      title: "Panen Raya",
      category: "Pertanian",
      description: "Syukuran panen raya hasil pertanian warga",
    },
    {
      id: 9,
      image: gallery3,
      title: "Senam Sehat",
      category: "Olahraga",
      description: "Senam bersama masyarakat setiap hari Minggu pagi",
    },
  ];

  const categories = ["Semua", "Pemerintahan", "Pertanian", "Budaya", "Ekonomi", "Kesehatan", "Acara", "Lingkungan", "Olahraga"];

  return (
    <div className="min-h-screen">
      <Navbar />

      {/* Header */}
      <section className="bg-gradient-hero py-20 mt-16">
        <div className="container mx-auto px-4 text-center text-primary-foreground">
          <Badge className="mb-4 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
            Dokumentasi
          </Badge>
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            Galeri Foto Kegiatan
          </h1>
          <p className="text-lg opacity-90 max-w-2xl mx-auto">
            Dokumentasi kegiatan dan momen penting di Desa Maju Sejahtera
          </p>
        </div>
      </section>

      {/* Filter Categories */}
      <section className="py-8 border-b border-border">
        <div className="container mx-auto px-4">
          <div className="flex flex-wrap gap-2 justify-center">
            {categories.map((category) => (
              <Badge
                key={category}
                variant={category === "Semua" ? "default" : "outline"}
                className="cursor-pointer hover:bg-primary hover:text-primary-foreground transition-colors px-4 py-2"
              >
                {category}
              </Badge>
            ))}
          </div>
        </div>
      </section>

      {/* Gallery Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {galleryItems.map((item) => (
              <Card key={item.id} className="group overflow-hidden cursor-pointer hover:shadow-xl transition-all duration-300">
                <div className="relative overflow-hidden">
                  <img
                    src={item.image}
                    alt={item.title}
                    className="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div className="absolute bottom-0 left-0 right-0 p-6 text-primary-foreground transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                      <Badge className="mb-2 bg-primary-foreground/20 text-primary-foreground border-primary-foreground/30">
                        {item.category}
                      </Badge>
                      <h3 className="text-xl font-bold mb-2">{item.title}</h3>
                      <p className="text-sm opacity-90">{item.description}</p>
                    </div>
                  </div>
                </div>
              </Card>
            ))}
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Galeri;
