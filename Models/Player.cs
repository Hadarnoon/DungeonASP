using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using Microsoft.EntityFrameworkCore;

namespace dungeonMaster_final.Models;

[Index("Username", Name = "UQ__Players__536C85E46111A356", IsUnique = true)]
[Index("Email", Name = "UQ__Players__A9D1053441BF0F20", IsUnique = true)]
public partial class Player
{
    [Key]
    [Column("PlayerID")]
    public int PlayerId { get; set; }

    [StringLength(50)]
    public string Username { get; set; } = null!;

    [StringLength(255)]
    public string PasswordHash { get; set; } = null!;

    [StringLength(100)]
    public string Email { get; set; } = null!;

    public int Level { get; set; }

    [Column("SP")]
    public int Sp { get; set; }

    public int Permission { get; set; }

    [Column(TypeName = "datetime")]
    public DateTime RegDate { get; set; }

    [InverseProperty("Player")]
    public virtual ICollection<MatchLog> MatchLogs { get; set; } = new List<MatchLog>();

    [InverseProperty("Player")]
    public virtual ICollection<UnlockedSkill> UnlockedSkills { get; set; } = new List<UnlockedSkill>();
}
