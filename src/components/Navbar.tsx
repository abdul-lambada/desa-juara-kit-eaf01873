import { useEffect, useRef, useState } from "react";
import { Link, useLocation } from "react-router-dom";
import { Menu, X, Building2, ChevronDown } from "lucide-react";
import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [openDropdown, setOpenDropdown] = useState<string | null>(null);
  const [expandedGroup, setExpandedGroup] = useState<string | null>(null);
  const hoverTimeout = useRef<ReturnType<typeof setTimeout> | null>(null);
  const location = useLocation();

  useEffect(() => {
    setIsOpen(false);
    setExpandedGroup(null);
    setOpenDropdown(null);
    if (hoverTimeout.current) {
      clearTimeout(hoverTimeout.current);
      hoverTimeout.current = null;
    }
  }, [location.pathname]);

  useEffect(() => () => {
    if (hoverTimeout.current) {
      clearTimeout(hoverTimeout.current);
    }
  }, []);

  const openWithDelay = (label: string) => {
    if (hoverTimeout.current) {
      clearTimeout(hoverTimeout.current);
    }
    hoverTimeout.current = setTimeout(() => {
      setOpenDropdown(label);
      hoverTimeout.current = null;
    }, 150);
  };

  const closeWithDelay = () => {
    if (hoverTimeout.current) {
      clearTimeout(hoverTimeout.current);
    }
    hoverTimeout.current = setTimeout(() => {
      setOpenDropdown(null);
      hoverTimeout.current = null;
    }, 200);
  };

  const navGroups = [
    { label: "Beranda", path: "/" },
    {
      label: "Profil",
      items: [
        { name: "Profil Desa", path: "/profil" },
        { name: "Transparansi", path: "/transparansi" },
      ],
    },
    {
      label: "Informasi",
      items: [
        { name: "Berita", path: "/berita" },
        { name: "Pengumuman", path: "/pengumuman" },
        { name: "Agenda", path: "/agenda" },
      ],
    },
    {
      label: "Layanan",
      items: [
        { name: "Layanan", path: "/layanan" },
        { name: "Produk UMKM", path: "/produk" },
      ],
    },
    {
      label: "Data & Statistik",
      items: [
        { name: "Statistik", path: "/statistik" },
        { name: "Peta Desa", path: "/peta-desa" },
      ],
    },
    { label: "Galeri", path: "/galeri" },
    { label: "Kontak", path: "/kontak" },
  ];

  const isActive = (path: string) => location.pathname === path;
  const isGroupActive = (group: { path?: string; items?: { path: string }[] }) =>
    group.path ? isActive(group.path) : group.items?.some((item) => isActive(item.path));
  const desktopLinkClasses = "inline-flex items-center rounded-full px-4 py-2 text-sm font-medium transition-colors";
  const desktopActiveClasses = "bg-primary text-primary-foreground shadow-sm";
  const desktopInactiveClasses = "text-muted-foreground hover:text-primary hover:bg-primary/10";
  const mobileLinkClasses = "block w-full rounded-lg px-4 py-2 text-base font-medium transition-colors";
  const mobileActiveClasses = "bg-primary text-primary-foreground";
  const mobileInactiveClasses = "text-foreground hover:bg-muted";
  const mobileSubLinkClasses = "block w-full rounded-md px-4 py-2 text-sm text-muted-foreground transition-colors hover:text-foreground hover:bg-muted/80";

  return (
    <nav className="fixed top-0 left-0 right-0 z-50 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 border-b border-border">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link to="/" className="flex items-center space-x-2 hover:opacity-80 transition-opacity">
            <div className="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
              <Building2 className="w-6 h-6 text-primary-foreground" />
            </div>
            <div className="hidden sm:block">
              <h1 className="font-bold text-lg text-foreground">Desa Digital</h1>
              <p className="text-xs text-muted-foreground">Desa Maju Sejahtera</p>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden md:flex flex-wrap items-center justify-end gap-1.5">
            {navGroups.map((group) => {
              const active = isGroupActive(group) ?? false;
              if (group.items && group.items.length > 0) {
                const isOpen = openDropdown === group.label;
                return (
                  <div
                    key={group.label}
                    className="relative"
                    onMouseEnter={() => openWithDelay(group.label)}
                    onMouseLeave={() => closeWithDelay()}
                  >
                    <button
                      type="button"
                      className={cn(
                        desktopLinkClasses,
                        "items-center gap-2",
                        active ? desktopActiveClasses : desktopInactiveClasses,
                      )}
                      onClick={() => {
                        if (hoverTimeout.current) {
                          clearTimeout(hoverTimeout.current);
                          hoverTimeout.current = null;
                        }
                        setOpenDropdown((prev) => (prev === group.label ? null : group.label));
                      }}
                    >
                      {group.label}
                      <ChevronDown className={cn("h-4 w-4 transition-transform", isOpen ? "rotate-180" : "rotate-0")} />
                    </button>
                    {isOpen && (
                      <div
                        className="absolute right-0 top-full mt-2 min-w-[200px] rounded-lg border bg-popover text-popover-foreground shadow-lg"
                        onMouseEnter={() => openWithDelay(group.label)}
                        onMouseLeave={() => closeWithDelay()}
                      >
                        <div className="py-2">
                          {group.items.map((item) => (
                            <Link
                              key={item.path}
                              to={item.path}
                              className="flex px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground"
                            >
                              {item.name}
                            </Link>
                          ))}
                        </div>
                      </div>
                    )}
                  </div>
                );
              }

              return (
                <Link
                  key={group.label}
                  to={group.path ?? "#"}
                  className={cn(
                    desktopLinkClasses,
                    active ? desktopActiveClasses : desktopInactiveClasses,
                  )}
                >
                  {group.label}
                </Link>
              );
            })}
          </div>

          {/* Mobile Menu Button */}
          <Button
            variant="ghost"
            size="icon"
            className="md:hidden"
            onClick={() => setIsOpen(!isOpen)}
          >
            {isOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
          </Button>
        </div>

        {/* Mobile Navigation */}
        {isOpen && (
          <div className="md:hidden py-4 space-y-2 animate-fade-in border-t border-border">
            {navGroups.map((group) => {
              const active = isGroupActive(group) ?? false;
              if (group.items && group.items.length > 0) {
                const expanded = expandedGroup === group.label;
                return (
                  <div key={group.label}>
                    <button
                      type="button"
                      className={cn(
                        mobileLinkClasses,
                        "flex items-center justify-between",
                        active ? mobileActiveClasses : mobileInactiveClasses,
                      )}
                      onClick={() => setExpandedGroup((prev) => (prev === group.label ? null : group.label))}
                    >
                      <span>{group.label}</span>
                      <ChevronDown className={cn("h-4 w-4 transition-transform", expanded ? "rotate-180" : "rotate-0")} />
                    </button>
                    {expanded && (
                      <div className="mt-1 space-y-1 pl-2">
                        {group.items.map((item) => (
                          <Link
                            key={item.path}
                            to={item.path}
                            className={cn(
                              mobileSubLinkClasses,
                              isActive(item.path) ? mobileActiveClasses : "",
                            )}
                          >
                            {item.name}
                          </Link>
                        ))}
                      </div>
                    )}
                  </div>
                );
              }

              return (
                <Link
                  key={group.label}
                  to={group.path ?? "#"}
                  className={cn(
                    mobileLinkClasses,
                    active ? mobileActiveClasses : mobileInactiveClasses,
                  )}
                >
                  {group.label}
                </Link>
              );
            })}
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
