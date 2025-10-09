import { Building2, Mail, Phone, MapPin, Facebook, Instagram, Twitter } from "lucide-react";
import { Link } from "react-router-dom";

const Footer = () => {
  return (
    <footer className="bg-muted/50 border-t border-border mt-20">
      <div className="container mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          {/* Branding */}
          <div className="space-y-4">
            <div className="flex items-center space-x-2">
              <div className="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                <Building2 className="w-6 h-6 text-primary-foreground" />
              </div>
              <div>
                <h3 className="font-bold text-foreground">Desa Digital</h3>
                <p className="text-xs text-muted-foreground">Desa Maju Sejahtera</p>
              </div>
            </div>
            <p className="text-sm text-muted-foreground">
              Website resmi Desa Maju Sejahtera, menyediakan informasi dan layanan untuk masyarakat.
            </p>
          </div>

          {/* Quick Links */}
          <div>
            <h4 className="font-semibold text-foreground mb-4">Tautan Cepat</h4>
            <ul className="space-y-2">
              <li>
                <Link to="/profil" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                  Profil Desa
                </Link>
              </li>
              <li>
                <Link to="/berita" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                  Berita
                </Link>
              </li>
              <li>
                <Link to="/galeri" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                  Galeri
                </Link>
              </li>
              <li>
                <Link to="/kontak" className="text-sm text-muted-foreground hover:text-primary transition-colors">
                  Kontak
                </Link>
              </li>
            </ul>
          </div>

          {/* Layanan */}
          <div>
            <h4 className="font-semibold text-foreground mb-4">Layanan</h4>
            <ul className="space-y-2">
              <li className="text-sm text-muted-foreground">Administrasi Kependudukan</li>
              <li className="text-sm text-muted-foreground">Surat Pengantar</li>
              <li className="text-sm text-muted-foreground">Pengaduan Masyarakat</li>
              <li className="text-sm text-muted-foreground">Informasi Desa</li>
            </ul>
          </div>

          {/* Kontak */}
          <div>
            <h4 className="font-semibold text-foreground mb-4">Hubungi Kami</h4>
            <ul className="space-y-3">
              <li className="flex items-start space-x-2 text-sm text-muted-foreground">
                <MapPin className="w-4 h-4 mt-0.5 flex-shrink-0" />
                <span>Jl. Raya Desa No. 123, Kec. Maju, Kab. Sejahtera, Provinsi Indonesia</span>
              </li>
              <li className="flex items-center space-x-2 text-sm text-muted-foreground">
                <Phone className="w-4 h-4 flex-shrink-0" />
                <span>(0274) 123-4567</span>
              </li>
              <li className="flex items-center space-x-2 text-sm text-muted-foreground">
                <Mail className="w-4 h-4 flex-shrink-0" />
                <span>info@desamajusejahtera.id</span>
              </li>
            </ul>

            {/* Social Media */}
            <div className="flex items-center space-x-3 mt-4">
              <a href="#" className="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center hover:bg-primary hover:text-primary-foreground transition-colors">
                <Facebook className="w-4 h-4" />
              </a>
              <a href="#" className="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center hover:bg-primary hover:text-primary-foreground transition-colors">
                <Instagram className="w-4 h-4" />
              </a>
              <a href="#" className="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center hover:bg-primary hover:text-primary-foreground transition-colors">
                <Twitter className="w-4 h-4" />
              </a>
            </div>
          </div>
        </div>

        <div className="border-t border-border mt-8 pt-8 text-center">
          <p className="text-sm text-muted-foreground">
            © {new Date().getFullYear()} Desa Maju Sejahtera. Hak Cipta Dilindungi.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
